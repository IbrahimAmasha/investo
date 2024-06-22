<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SessionBooked
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $mentorId;
    public $sessionId;
    public $message;

    public function __construct($userId, $mentorId, $sessionId, $message)
    {
        $this->userId = $userId;
        $this->mentorId = $mentorId;
        $this->sessionId = $sessionId;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('mentor.' . $this->mentorId);
    }

    public function broadcastWith()
    {
        return [
            'userId' => $this->userId,
            'mentorId' => $this->mentorId,
            'sessionId' => $this->sessionId,
            'message' => $this->message,
        ];
    }
}
