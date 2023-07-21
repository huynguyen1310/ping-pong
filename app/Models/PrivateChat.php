<?php

namespace App\Models;

class PrivateChat extends Chat
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'User_Chat', 'chat_id', 'user_id')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'chat_id');
    }

    public function scopeBetweenUsers($query, $sender_id, $receiver_id)
    {
        return $query->whereRaw('(sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)', [$sender_id, $receiver_id, $receiver_id, $sender_id]);
    }
}
