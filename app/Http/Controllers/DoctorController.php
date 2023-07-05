<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Requests\AddExperienceRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Experience;
use Illuminate\Support\Carbon;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\EditExaminationsRequest;
use App\Models\Review;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $allratings = [];

        $city = $request->input('city');

        if ($city) {
            $doctors = Doctor::where('city', $city)->with(['specializations', 'subscriptions' => function ($query) {
                $query->where('end_date', '>', Carbon::now());
            }, 'reviews', 'experiences'])->paginate(10);
            $doctors->appends(['city' => $city]);
        } else {
            $doctors = Doctor::latest()->with(['specializations', 'subscriptions' => function ($query) {
                $query->where('end_date', '>', Carbon::now());
            }, 'reviews', 'experiences'])->paginate(10);
        }



        $doctors->makeHidden(['user_id', 'created_at', 'updated_at', 'subscriptions']); //escludi campi
        foreach ($doctors as $doctor) { //sposta campi da user a doctor e aggiungi rating medio
            $user = User::where('id', $doctor->user_id)->first();
            $doctor->name = $user->name;
            $doctor->surname = $user->surname;
            $doctor->slug = $user->slug;
          //  dd($doctor->subscriptions->count());
            if ($doctor->subscriptions->count() != 0) {
                $doctor->premium = true;
            }
            else {
                $doctor->premium = false;
            }

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

            $allratings = []; //svuoto array per il prox dottore
        }
        if ($doctors->isEmpty()) {
            return response()->json([
                'success' => false,
                'results' => 'No doctors found'
            ], 404);
        } else {
            return response()->json(
                [
                    'success' => true,
                    'results' => $doctors
                ]
            );
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
        $doctor->load('specializations', 'reviews');

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


        $randId = rand(1,300);
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

        }
        else {
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

    public function uploadProfile(Request $request) {

        $loggedID = Auth::user()->id;

        $doctor = Doctor::where('user_id', $loggedID)->first();


        $img_path = 'http://127.0.0.1:8000/storage/' . Storage::disk('public')->put('uploads', $request->file('image'));




        $doctor->profile_image_url = $img_path;

        $doctor->save();

        $responseData = ['imagelink' => $img_path];

        return response()->json($responseData, 200, [], JSON_UNESCAPED_SLASHES);

    }

    public function addExperience(AddExperienceRequest $request) {
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

    public function editExaminations(EditExaminationsRequest $request) {

        $loggedID = Auth::user()->id;
        $doctor = Doctor::where('user_id', $loggedID)->first();
        $doctor->examinations = $request->validated('examinations');
        $doctor->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Esperienze modificate'
        ], 200);

    }




}
