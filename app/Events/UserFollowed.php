<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserFollowed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $followerId;
    public $followerName;
    public $followeeId;

    public function __construct($followerId, $followerName, $followeeId)
    {
        $this->followerId = $followerId;
        $this->followerName = $followerName;
        $this->followeeId = $followeeId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('user.' . $this->followeeId);
    }

    public function broadcastWith()
    {
        return [
            'followerId' => $this->followerId,
            'followerName' => $this->followerName,
            'message' => $this->followerName . ' قام بمتابعتك !'
        ];
    }
}
