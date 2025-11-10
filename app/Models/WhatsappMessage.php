<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappMessage extends Model
{
    //
     protected $fillable = [
        'conversation_id',
        'sender_type',
        'direction',
        'message_body',
        'twilio_sid'
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
