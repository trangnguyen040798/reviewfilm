<?php

namespace App\Events;

use App\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NewComment implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function broadcastWith()
    {
        if ($this->comment->created_at != $this->comment->updated_at) {
            $diff = formatTimeDate($this->comment->updated_at);
            $updated = true;
        } else {
            $diff = formatTimeDate($this->comment->created_at);
            $updated = false;
        }
        return [
            'id' => $this->comment->id,
            'body' => $this->comment->body,
            'user' => [
                'name' => $this->comment->user->name,
                'id' => $this->comment->user->id,
                'api_token' => $this->comment->user->api_token,
                'image' => $this->comment->user->image
            ],
            'path_image' => asset('') . config('admin.default_folder_image'),
            'diff' => $diff,
            'rating' => $this->comment->rating,
            'updated' => $updated
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('comment');
    }
}
