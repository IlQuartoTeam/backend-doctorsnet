<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\Review;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


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
            }, 'reviews'])->paginate(10);
            $doctors->appends(['city' => $city]);
        } else {
            $doctors = Doctor::latest()->with(['specializations', 'subscriptions' => function ($query) {
                $query->where('end_date', '>', Carbon::now());
            }, 'reviews'])->paginate(10);
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
        $doctor->load('specializations');

        $allratings = [];
        $user = User::where('id', $doctor->user_id)->first();
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

            return response()->json(
                [
                    'success' => true,
                    'results' => $doctor
                ]
            );
        }
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
        if ($request->filled('phone')) {
            $doctorLogged->phone = $request->input('phone');
        }

        if ($request->filled('profile_image_url')) {
            $doctorLogged->profile_image_url = $request->input('profile_image_url');
        }

        if ($request->filled('examinations')) {
            $doctorLogged->examinations = $request->input('examinations');
        }
        $randId = rand(1,300);
        $newSlug = Str::slug($request->validated('name') . '-' . $request->validated('surname') . '-' . $randId);
        $doctorLogged->slug = $newSlug;
        $user->slug = $newSlug;
        $doctorLogged->save();
        $user->save();

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
}
