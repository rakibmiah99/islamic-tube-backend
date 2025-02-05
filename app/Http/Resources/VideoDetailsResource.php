<?php

namespace App\Http\Resources;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $related_videos = Video::relatedVideosData($this->tags->pluck('id'), $this->id);
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail,
            'description' => $this->description,
            'long_description' => $this->long_description,
            'video_id' => $this->video_id,
            'provider' => $this->provider,
            'published_at' => $this->published_at,
            'watch_count' => (integer)$this->watch_counts_sum_watch_count,
            'likes_count' => (integer)$this->likes_count,
            'comments_count' => (integer)$this->comments_count,
            'like' => $this->user_reaction?->reaction == "l",
            'dislike' => $this->user_reaction?->reaction == "d",
            'related_videos' => [
                'token' => $related_videos['token'],
                'data' => VideoResource::collection($related_videos['data'])
            ],
            'comments' => [
                'token' => Video::LoadMoreCommentPack(video_id: $this->id),
                'data' => CommentResource::collection($this->comments()->limit(15)->get())
            ]
        ];
    }
}
