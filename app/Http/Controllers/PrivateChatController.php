<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\PrivateChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivateChatController extends Controller
{
    public function index()
    {
        // Get all private chats for the authenticated user
        $privateChats = Auth::user()->privateChats;

        return response()->json(['private_chats' => $privateChats], 200);
    }

    public function getMessageBetweenTwoUsers($user_id)
    {
        // Retrieve the private chat between the authenticated user and the specified user
        $privateChat = PrivateChat::betweenUsers(Auth::id(), $user_id)->firstOrFail();

        // Retrieve all messages in the private chat
        $messages = $privateChat->messages;

        return response()->json([
            'private_chat' => $privateChat,
            'messages' => $messages->load('sender'),
        ], 200);
    }

    public function sendMessageBetweenTwoUsers(Request $request, $user_id)
    {
        // Retrieve the private chat between the authenticated user and the specified user
        $privateChat = PrivateChat::betweenUsers(Auth::id(), $user_id)->first();

        // If a private chat doesn't exist, create one
        if (! $privateChat) {
            $privateChat = new PrivateChat;
            $privateChat->sender_id = Auth::id();
            $privateChat->receiver_id = $user_id;
            $privateChat->save();
        }

        // Create a new message
        $message = new Message();
        $message->sender_id = Auth::id();
        $message->content = $request->input('content');

        // Associate the message with the private chat and save it
        $privateChat->messages()->save($message);

        broadcast(new MessageSent($message->load('sender')))->toOthers();

        return response()->json(['message' => 'Message sent successfully'], 200);
    }
}
