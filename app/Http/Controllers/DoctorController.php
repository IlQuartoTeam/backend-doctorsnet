<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use Illuminate\Support\Facades\Auth;


class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
