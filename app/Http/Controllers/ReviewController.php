<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Doctor;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Doctor $doctor)
    {
        $reviews = Review::where('doctor_id', $doctor->id)
                   ->orderBy('created_at', 'desc')->paginate(5);

                   return response()->json(
                        $reviews
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
    public function store(StoreReviewRequest $request, Doctor $doctor)
    {
        $review = new Review();
        $review->doctor_id = $doctor->id;
        $review->email = $request->validated('email');
        $review->name = $request->validated('name');
        $review->rating = $request->validated('rating');
        $review->text = $request->validated('text');
        $review->save();

        return response()->json(
            [
                'success' => true,
                'message' => 'Review added'
            ]
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(Review $Review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $Review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $Review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $Review)
    {
        //
    }
}
