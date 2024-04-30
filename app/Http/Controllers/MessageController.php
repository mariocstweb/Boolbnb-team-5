<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::whereRelation('apartment', 'user_id', Auth::id())->get();

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $message = new Message();

        return view('admin.messages.create', compact('message'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'content' => 'required'
            ],
            [
                'name.required' => 'Il titolo è obbligatorio',
                'email.required' => 'La mail è obbligatoria',
                'email.email' => 'La mail non è scritta nel formato giusto',
                'content.required' => 'Il contenuto è obbligatorio'
            ]
        );

        // Insert message
        $message = new Message();

        $message->fill($data);

        // Save message
        $message->save();

        return to_route('admin.messages.index')->with('alert-message', 'Messaggio creato con successo')->with('alert-type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
