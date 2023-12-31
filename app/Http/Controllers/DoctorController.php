<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Requests\AddExperienceRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Experience;
use App\Models\Specialization;
use Illuminate\Support\Carbon;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\EditExaminationsRequest;
use App\Models\Review;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $doctorsQuery = Doctor::leftjoin('doctor_subscription', 'doctor_subscription.doctor_id', '=', 'doctors.id')
            ->join('reviews', 'reviews.doctor_id', '=', 'doctors.id')
            ->select('doctors.*', 'doctor_subscription.end_date', DB::raw('AVG(reviews.rating) as average_rating'))
            ->with(['specializations', 'reviews', 'experiences'])
            ->groupBy('doctors.id')
            ->orderBy('doctor_subscription.end_date', 'desc');

        $city = $request->input('city');
        $specializationName = $request->input('specialization');
        $vote = $request->input('vote');
        $numRec = $request->input('nReviews');



        if ($request->filled('city')) {
            $doctorsQuery->where('city', $city);
        }



        if ($request->filled('nReviews')) {

            $doctorsQuery->select('doctors.*', 'doctor_subscription.end_date', DB::raw('AVG(reviews.rating) as average_rating'), DB::raw('COUNT(reviews.id) as reviews_number'))->having('reviews_number', '>=', $numRec);
        }

        if ($request->filled('specialization')) {
            $specializationDB = Specialization::where('name', $specializationName)->first();
            $specializationID = $specializationDB->id;
            $doctorsQuery->whereHas('specializations', function ($q) use ($specializationID) {
                $q->where('doctor_specialization.specialization_id', $specializationID);
            });
        }

        if ($request->filled('vote')) {
            $doctorsQuery->having('average_rating', '>=', $vote);
        }

        $doctors = $doctorsQuery->paginate(10)->appends(request()->query());

        $doctors->makeHidden(['user_id', 'created_at', 'updated_at', 'subscriptions', 'subscription_id', 'doctor_id', 'end_date']);

        foreach ($doctors as $doctor) {
            $user = User::where('id', $doctor->user_id)->first();
            $doctor->name = $user->name;
            $rounded_rating = round($doctor->average_rating, 2);
            $doctor->average_rating = $rounded_rating;
            $doctor->surname = $user->surname;
            $doctor->slug = $user->slug;

            if ($doctor->end_date >= Carbon::now()) {
                $doctor->premium = true;
            } else {
                $doctor->premium = false;
            }
        }

        if ($doctors->isEmpty()) {
            return response()->json([
                'success' => false,
                'results' => 'No doctors found'
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'results' => $doctors
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        $doctor->load('specializations', 'experiences', 'reviews');

        $allratings = [];
        $user = User::where('id', $doctor->user_id)->first();
        $doctor->email = $user->email;
        $doctor->name = $user->name;
        $doctor->surname = $user->surname;
        $doctor->slug = $user->slug;

        $reviews = Review::where('doctor_id', $doctor->id)->get();
        foreach ($reviews as $review) { //prendo i voti e li metto in un array
            array_push($allratings, $review->rating);
        }
        //calcolo media
        if (count($allratings) > 0) {
            $sum = array_sum($allratings);
            $count = count($allratings);

            $average = $sum / $count;
            $doctor->average_rating = round($average, 1);
        }
        return response()->json(
            [
                'success' => true,
                'results' => $doctor
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $Doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request)
    {

        $loggedID = Auth::user()->id;

        $user = User::where('id', $loggedID)->first();

        $user->name = $request->validated('name');
        $user->surname = $request->validated('surname');
        $doctorLogged = Doctor::where('user_id', $loggedID)->first();
        $doctorLogged->address = $request->validated('address');
        $doctorLogged->city = $request->validated('city');
        $doctorLogged->address_lat = $request->address_lat;
        $doctorLogged->address_long = $request->address_long;
        if ($request->filled('phone')) {
            $doctorLogged->phone = $request->input('phone');
        }


        $randId = rand(1, 300);
        $newSlug = Str::slug($request->validated('name') . '-' . $request->validated('surname') . '-' . $randId);
        $doctorLogged->slug = $newSlug;
        $user->slug = $newSlug;
        $doctorLogged->save();
        $user->save();

        $doctorLogged->specializations()->sync($request->validated('specializations'));


        return response()->json([
            'status' => 'updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $Doctor)
    {
        //
    }

    public function changePassword(ChangePasswordRequest $request)

    {
        $user = Auth::user();
        if ((!Hash::check($request->validated('oldPassword'), $user->password))) {
            return response()->json([
                'status' => 'failed',
                'message' => 'La vecchia password non è corretta'
            ], 401);
        } else {
            $newpassword = Hash::make($request->validated('newPassword'));
            $changeUser = User::findOrFail($user->id);
            $changeUser->password = $newpassword;
            $changeUser->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Password modificata'
            ], 200);
        }
    }

    public function uploadProfile(Request $request)
    {

        $loggedID = Auth::user()->id;

        $doctor = Doctor::where('user_id', $loggedID)->first();


        $img_path = 'http://127.0.0.1:8000/storage/' . Storage::disk('public')->put('uploads', $request->file('image'));




        $doctor->profile_image_url = $img_path;

        $doctor->save();

        $responseData = ['imagelink' => $img_path];

        return response()->json($responseData, 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function addExperience(AddExperienceRequest $request)
    {
        $loggedID = Auth::user()->id;

        $newExp = new Experience();
        $newExp->doctor_id = $loggedID;
        $newExp->name = $request->validated('name');
        $newExp->type = $request->validated('type');
        $newExp->start_date = $request->validated('start_date');
        if ($request->has('end_date')) {
            $newExp->end_date = $request->validated('end_date');
        }
        $newExp->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Esperienza aggiunta'
        ], 200);
    }

    public function editExaminations(EditExaminationsRequest $request)
    {

        $loggedID = Auth::user()->id;
        $doctor = Doctor::where('user_id', $loggedID)->first();
        $doctor->examinations = $request->validated('examinations');
        $doctor->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Esperienze modificate'
        ], 200);
    }

    public function premiumDoctors()
    {

        $doctorsPremium = Doctor::leftjoin('doctor_subscription', 'doctor_subscription.doctor_id', '=', 'doctors.id')
            ->select('doctors.*', 'doctor_subscription.end_date')
            ->where('doctor_subscription.end_date', '>=', Carbon::now())
            ->with(['specializations', 'reviews'])
            ->inRandomOrder()
            ->limit(10)
            ->get();

        foreach ($doctorsPremium as $doctor) {
            $user = User::where('id', $doctor->user_id)->first();
            $doctor->name = $user->name;
            $doctor->surname = $user->surname;
            $doctor->premium = true; //gestione frontend
        }


        return response()->json([
            'premiumUsers' => $doctorsPremium
        ], 200);
    }

    public function messageStats(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $loggedID = Auth::user()->id;
        $doctor = Doctor::where('user_id', $loggedID)->first();

        $listMessages = [];

        $messages = $doctor->messages()->whereBetween('created_at', [$start_date, $end_date])->get();

        foreach ($messages as $message) {
            $receivedDate = $message->created_at->format('Y-m-d');
            if (!isset($listMessages[$receivedDate])) {
                $listMessages[$receivedDate] = 0;
            }
            $listMessages[$receivedDate]++;
        }




        return response()->json([
            'statsMessages' => $listMessages
        ], 200);
    }

    public function reviewsStats(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $loggedID = Auth::user()->id;
        $doctor = Doctor::where('user_id', $loggedID)->first();
        $type = $request->type;


        $listReviews = [];

        $reviews = $doctor->reviews()->whereBetween('created_at', [$start_date, $end_date])->get();

        foreach ($reviews as $review) {
            $receivedDate = $review->created_at;

            if (empty($type)) {
                return response()->json([
                   "error" => 'Seleziona giorno, settimana, mese o anno'
                ], 200);
            }

            else if ($type === 'day') {
                $receivedDate = $receivedDate->format('Y-m-d');
            } else if ($type === 'week') {
                $receivedDate = $receivedDate->format('Y-W');
            } else if ($type === 'month') {
                $receivedDate = $receivedDate->format('Y-m');
            } else if ($type === 'year') {
                $receivedDate = $receivedDate->format('Y');
            }

            $rating = $review->rating;

            if (!isset($listReviews[$receivedDate])) {
                $listReviews[$receivedDate] = [];
            }

            if (!isset($listReviews[$receivedDate][$rating])) {
                $listReviews[$receivedDate][$rating] = 0;
            }

            $listReviews[$receivedDate][$rating]++;
        }

        return response()->json([
            'statsReviews' => $listReviews
        ], 200);
    }

    public function reviewsStatsSimple(Request $request) {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $loggedID = Auth::user()->id;
        $doctor = Doctor::where('user_id', $loggedID)->first();

        $listReviews = [];

        $reviews = $doctor->reviews()->whereBetween('created_at', [$start_date, $end_date])->get();

        foreach ($reviews as $review) {
            $receivedDate = $review->created_at->format('Y-m-d');
            if (!isset($listReviews[$receivedDate])) {
                $listReviews[$receivedDate] = 0;
            }
            $listReviews[$receivedDate]++;
        }

        return response()->json([
            'statsReviews' => $listReviews
        ], 200);
    }


}
