<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Models\Doctor;

class MessageController extends Controller
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
    public function store(StoreMessageRequest $request, Doctor $doctor)
    {
        $message = new Message();
        $message->doctor_id = $doctor->id;
        $message->text = $request->validated('text');
        $message->email = $request->validated('email');
        $message->fullname = $request->validated('fullname');
        $message->prefered_date = $request->validated('prefered_date');
        $message->ip = $request->ip();
        $message->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Messaggio inviato'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $Message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $Message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Message $Message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $Message)
    {
        //
    }
}
