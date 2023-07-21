<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
  public function privateChat()
  {
    $user = auth()->user();
  }
}
