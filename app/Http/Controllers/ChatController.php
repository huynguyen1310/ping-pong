<?php

namespace App\Http\Controllers;

class ChatController extends Controller
{
    public function privateChat()
    {
        $user = auth()->user();
    }
}
