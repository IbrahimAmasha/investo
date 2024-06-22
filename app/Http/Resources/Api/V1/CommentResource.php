<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Set Carbon locale to Arabic
        Carbon::setLocale('ar');

        // Parse the created_at time
        $createdAt = Carbon::parse($this->created_at);

        return [
            'comment_id' => $this->id,
            'content' => $this->content,
            'user_id' => $this->user_id,
            'user_name' => $this->user->f_name . ' ' . $this->user->l_name, // Include user name
            'user_image' => $this->user->image, // Include user image
            'post_id' => $this->post_id,
            'likes' => $this->likes,
            'dislikes' => $this->dislikes,
            'created_at' => $this->formatCreatedAt($createdAt), // Formatted date in Arabic
        ];
    }

    /**
     * Format the created_at attribute based on the given conditions in Arabic.
     *
     * @param \Carbon\Carbon $createdAt
     * @return string
     */
    private function formatCreatedAt(Carbon $createdAt): string
    {
        $now = Carbon::now();
        $diffInMinutes = $createdAt->diffInMinutes($now);
        $diffInHours = $createdAt->diffInHours($now);

        if ($diffInMinutes < 60) {
            return $this->formatMinutesInArabic($diffInMinutes);
        } elseif ($diffInHours < 24) {
            return $this->formatHoursInArabic($diffInHours);
        } else {
            return 'في ' . $createdAt->translatedFormat('l، j F Y'); // Custom format e.g., الاثنين، 1 يناير 2024
        }
    }

    /**
     * Format minutes in Arabic.
     *
     * @param int $minutes
     * @return string
     */
    private function formatMinutesInArabic(int $minutes): string
    {
        return "منذ {$minutes} دقيقة" . ($minutes === 1 ? '' : '');
    }

    /**
     * Format hours in Arabic.
     *
     * @param int $hours
     * @return string
     */
    private function formatHoursInArabic(int $hours): string
    {
        return "منذ {$hours} ساعة" . ($hours === 1 ? '' : '');
    }
}
