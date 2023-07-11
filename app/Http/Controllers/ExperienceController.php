<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Http\Requests\StoreExperienceRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\Review;
use App\Http\Requests\UpdateExperienceRequest;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Doctor $doctor)
    {
        $work = Experience::where('doctor_id', $doctor->id)->where('type', 'work')
            ->orderBy('start_date', 'desc')->get();

        $education = Experience::where('doctor_id', $doctor->id)->where('type', 'education')
            ->orderBy('start_date', 'desc')->get();

        return response()->json(
            ['work' => $work,
            'education' => $education]
        );
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
    public function store(StoreExperienceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Experience $Experience)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Experience $Experience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExperienceRequest $request, Experience $Experience)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experience $Experience)
    {

        $loggedID = Auth::user()->id;
        if ($Experience->doctor_id != $loggedID) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Richiesta impropria'
            ], 401);
        } else {

            $Experience->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Esperienza cancellata'
            ], 200);
        }
    }
}
