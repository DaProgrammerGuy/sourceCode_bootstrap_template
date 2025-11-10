<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssignRole implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $role;

    public function __construct($user, $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function broadcastOn(): array
    {
        return [new Channel('public-chat')];
    }

    public function broadcastAs(): string
    {
        return 'role.changed';
    }
}
