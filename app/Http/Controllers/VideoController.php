<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoCommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\VideoDetailsResource;
use App\Http\Resources\VideoResource;
use App\Models\Comment;
use App\Models\Video;
use App\Models\VideoReaction;
use App\Utils\Helper;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function allVideos(Request $request)
    {
        $limit = $request->input('limit', 24);
        $offset = $request->input('offset', 0);


        $videos = Video::withSum('watch_counts', 'watch_count')
            ->limit($limit)
            ->offset($offset)
            ->get();

        $next_load = $offset + $limit;
        $next_load_url = route('all-videos', ['offset' => $next_load]);
        return Helper::ApiResponse('', [
            'next_load' => $next_load_url,
            'query' => [
                'limit' => $limit,
                'current_offset' => $offset,
                'next_offset' => $next_load,

            ],
            'data' => VideoResource::collection($videos),
        ]);
    }

    public function search($text, Request $request)
    {
        $limit = 15;
        $offset = 0;

        try {
            $token = $request->next_load_token;
            $meta_data = Video::LoadMoreSearchUnPack($token);
            $text = $meta_data->text;
            $limit = $meta_data->limit;
            $offset = $meta_data->next_offset;
        }
        catch (\Exception $e) {
            //skip unpack error
        }

        $videos = Video::where('title', 'like', '%' . $text . '%')->withSum('watch_counts', 'watch_count');
        $total_data = $videos->count('id');

        $videos = $videos->limit($limit)->offset($offset)->get();


        return Helper::ApiResponse('', [
            'next_load_token' => $videos->count() == 0 ? false :  Video::LoadMoreSearchPack($text, $offset),
            'total_data' => $total_data,
            'data' => VideoResource::collection($videos),
        ]);
    }


    function videoDetail($slug)
    {
        $video = Video::where('slug', $slug)
            ->withSum('watch_counts', 'watch_count')
            ->withCount('likes')
            ->withCount('comments')
            ->firstOrFail();

        $video_details = VideoDetailsResource::make($video);
        return Helper::ApiResponse('', $video_details);
    }

    function moreRelatedVideos($token)
    {
        $meta_data = Video::RelatedVideoTokenUnPack($token);
        $related_videos_data =Video::relatedVideosData(
            tag_ids: $meta_data->tags,
            skip_video_id: $meta_data->video_id,
            offset: $meta_data->next_offset,
        );
        $data = [
            'token' => $related_videos_data['token'],
            'data' => VideoResource::collection($related_videos_data['data']),
        ];

        return Helper::ApiResponse('', $data);
    }

    function loadMoreComment($token)
    {
        $meta_data = Video::LoadMoreCommentUnPack($token);
        $comments = Comment::where('video_id', $meta_data->video_id)
            ->skip($meta_data->next_offset)
            ->take($meta_data->limit)
            ->get();

        return Helper::ApiResponse('', [
            'token' => Video::LoadMoreCommentPack(video_id: $meta_data->video_id, offset: $meta_data->next_offset),
            'data' => CommentResource::collection($comments),
        ]);
    }


    function comment($slug, VideoCommentRequest $request)
    {

        $video = Video::where('slug', $slug)->select('id')->firstOrFail();
        $video_id = $video->id;
        $user_id = auth()->id();
        $body = $request->input('body');
        $comment = Comment::create([
            'user_id' => $user_id,
            'video_id' => $video_id,
            'body' => $body,
        ]);

        $comment =  CommentResource::make($comment);
        return Helper::ApiResponse('Comment created!', $comment);
    }

    public function like($slug)
    {
        $video = Video::where('slug', $slug)->withCount('likes')->firstOrFail();
        $video_id = $video->id;
        $user_id = auth()->id();
        $condition = ['user_id' => $user_id, 'video_id' => $video_id];
        $video_reaction = VideoReaction::where($condition)->first();
        $reaction = 'l'; // l = like
        if($video_reaction && $video_reaction?->reaction == 'l'){
            $reaction = 'n'; // n = none
        }

        VideoReaction::updateOrCreate($condition, ['reaction' => $reaction]);

        return Helper::ApiResponse('', [
            'like' => $video_reaction->reaction === 'n',
            'video_likes_count' => $video->likes_count,
        ]);
    }
    public function dislike($slug)
    {
        $video = Video::where('slug', $slug)->withCount('likes')->firstOrFail();
        $video_id = $video->id;
        $user_id = auth()->id();
        $condition = ['user_id' => $user_id, 'video_id' => $video_id];
        $video_reaction = VideoReaction::where($condition)->first();
        $reaction = 'd'; // l = like
        if($video_reaction && $video_reaction?->reaction == 'd'){
            $reaction = 'n'; // n = none
        }

        VideoReaction::updateOrCreate($condition, ['reaction' => $reaction]);

        return Helper::ApiResponse('', [
            'dislike' => $video_reaction->reaction === 'n',
            'video_likes_count' => $video->likes_count,
        ]);
    }


}
