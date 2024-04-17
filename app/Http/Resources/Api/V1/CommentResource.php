<?php

namespace App\Http\Resources\Api\V1;

// use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $user_first_name  = User::find($this->user_id)->first()->f_name;
        // $user_last_name  = User::find($this->user_id)->first()->l_name;
        
        return [
            'id' => $this->id,
            'content' => $this->content,
            'post_id' => $this->post_id,
            'user_id' => $this->user_id,
            // 'user name' => $user_first_name . ' ' . $user_last_name,
            
        ];
    }
}
