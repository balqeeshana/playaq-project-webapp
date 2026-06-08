<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Show messages thread with specific receiver.
     */
    public function show($receiverId)
    {
        $sender = Auth::user();
        $receiver = User::findOrFail($receiverId);

        // Fetch messages between sender and receiver sorted by time
        $messages = Message::where(function($q) use ($sender, $receiver) {
            $q->where('sender_id', $sender->id)->where('receiver_id', $receiver->id);
        })->orWhere(function($q) use ($sender, $receiver) {
            $q->where('sender_id', $receiver->id)->where('receiver_id', $sender->id);
        })->orderBy('created_at', 'asc')->get();

        return view('chat.show', [
            'receiver' => $receiver,
            'messages' => $messages,
        ]);
    }

    /**
     * Send message.
     */
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => ['required', 'exists:users,id'],
            'text' => ['required', 'string'],
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'text' => $request->text,
        ]);

        return back()->with('success', 'Message sent!');
    }
}
