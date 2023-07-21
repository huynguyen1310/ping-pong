<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
  public function index(Request $request)
  {
    $messages = Message::with(['sender'])->where('room', $request->query('room', ''))->orderBy('created_at', 'asc')->get();
    return $messages;
  }

  public function store(Request $request)
  {
    $message = new Message();
    $message->room = $request->input('room', '');
    $message->sender = Auth::user()->id;
    $message->content = $request->input('content', '');

    $message->save();

    broadcast(new MessageSent($message->load('sender')))->toOthers();

    return response()->json(['message' => $message->load('sender')]);
  }
}
