<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteMessageRequest;
use App\Http\Requests\ReadMessageRequest;
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
    public function destroy(DeleteMessageRequest $request, int $messageId)
    {
        $messToDel = Message::find($messageId);

        if(!$messToDel) {
            return response()->json([
                'error' => 'Non so che dirti, prova a refreshare',
                404
            ]);
        }

        $messToDel->delete();

        return response()->json([
            "success" => "Addios messaggio",
            200
        ]);

    }

    public function read(ReadMessageRequest $request) {
        $messageId = $request->input('messageId');
        $message = Message::find($messageId);
        if(!$message) {
            return response()->json([
                'error' => 'Ma che id mhai mandato?',
                404
            ]);
        }

        $message->been_read = $request->input('readAction') ? 1 : 0;
        $message->save();


        return response()->json([
            'success' => 'The message has been read',
            200
        ]);
    }
}
