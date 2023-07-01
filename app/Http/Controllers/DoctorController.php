<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Review;
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
            $doctors = Doctor::where('city', $city)->with('specializations')->paginate(10);
            $doctors->appends(['city' => $city]);
        } else {
            $doctors = Doctor::latest()->with('specializations')->paginate(10);
        }



        $doctors->makeHidden(['user_id', 'created_at', 'updated_at']); //escludi campi
        foreach ($doctors as $doctor) { //sposta campi da user a doctor e aggiungi rating medio
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
    public function show(Doctor $Doctor)
    {
        //
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
        $doctorLogged->save();

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
