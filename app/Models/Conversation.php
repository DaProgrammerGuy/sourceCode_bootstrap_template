<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    //
      protected $fillable = [
        'user_phone',
        'teacher_id',
        'status',
        'last_message_at',
        'session_timeout_minutes'
    ];

    protected $casts = [
        'last_message_at' => 'datetime'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function messages()
    {
        return $this->hasMany(WhatsappMessage::class);
    }

    public function isSessionExpired()
    {
        if (!$this->last_message_at) return true;
        
        return $this->last_message_at->diffInMinutes(now()) > $this->session_timeout_minutes;
    }
}
