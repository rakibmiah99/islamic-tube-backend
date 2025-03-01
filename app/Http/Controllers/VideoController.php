<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoCommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\VideoDetailsResource;
use App\Http\Resources\VideoResource;
use App\Models\Comment;
use App\Models\UserWatchControl;
use App\Models\Video;
use App\Models\VideoReaction;
use App\Models\VideoWatchCount;
use App\Utils\Helper;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function allVideos(Request $request)
    {


        $limit = $request->input('limit', 24);
        $offset = $request->input('offset', 0);


        $videos = Video::watchControl()->withSum('watch_counts', 'watch_count')
            ->limit($limit)
            ->offset($offset)
            ->get();


        /*এটি পরবর্তিতে প্রজেক্ট পাবলিশ এর আগে কিউ তে রান করাটা প্রয়োজন*/
        try{
            $video_ids = $videos->pluck('id')->toArray();
            $date = date('Y-m-d');
            $ip = $request->ip();
            $user_id = auth()->check() ? auth()->id() : null;
            UserWatchControl::insert([
                'user_id' => $user_id,
                'video_ids' => json_encode($video_ids),
                'ip_address' => $ip,
                'watch_date' => $date,
            ]);
        }
        catch (\Exception $exception){
            dd($exception->getMessage());
        }


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
        $ip = request()->ip();
        $date = date('Y-m-d');

        $video = Video::where('slug', $slug)
            ->withSum('watch_counts', 'watch_count')
            ->withCount('likes')
            ->withCount('comments')
            ->firstOrFail();


        /*এটি পরবর্তিতে প্রজেক্ট পাবলিশ এর আগে কিউ তে রান করাটা প্রয়োজন*/
        try{
            $watchRecord = VideoWatchCount::firstOrCreate(
                ['video_id' => $video->id, 'ip' => $ip, 'watch_date' => $date],
                ['watch_count' => 0]
            );

            $watchRecord->increment('watch_count');

        }
        catch (\Exception $exception){
            dd($exception->getMessage());
        }


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

        $video_query = Video::where('slug', $slug)->select('id');
        $video = $video_query->firstOrFail();

        $video_id = $video->id;
        $user_id = auth()->id();
        $body = $request->input('body');
        $comment = Comment::create([
            'user_id' => $user_id,
            'video_id' => $video_id,
            'body' => $body,
        ]);

        $comment =  CommentResource::make($comment);
        return Helper::ApiResponse('Comment created!', [
            'comment' => $comment,
            'total_comment' => $video->comments()->count('id')
        ]);
    }

    public function like($slug)
    {
        $query = Video::where('slug', $slug)->withCount('likes');

        $video = $query->firstOrFail();
        $video_id = $video->id;
        $user_id = auth()->id();
        $condition = ['user_id' => $user_id, 'video_id' => $video_id];

        $video_reaction_query = VideoReaction::where($condition);
        $video_reaction = $video_reaction_query->first();
        $reaction = 'l'; // l = like
        if($video_reaction && $video_reaction?->reaction == 'l'){
            $reaction = 'n'; // n = none
        }

        VideoReaction::updateOrCreate($condition, ['reaction' => $reaction]);

        return Helper::ApiResponse('', [
            'like' => $video_reaction_query->first()->reaction === 'l',
            'dislike' => $video_reaction_query->first()->reaction === 'd',
            'video_likes_count' => $query->first()->likes_count,
        ]);
    }
    public function dislike($slug)
    {
        $query = Video::where('slug', $slug)->withCount('likes');

        $video = $query->firstOrFail();
        $video_id = $video->id;
        $user_id = auth()->id();
        $condition = ['user_id' => $user_id, 'video_id' => $video_id];

        $video_reaction_query = VideoReaction::where($condition);
        $video_reaction = $video_reaction_query->first();
        $reaction = 'd'; // l = like
        if($video_reaction && $video_reaction?->reaction == 'd'){
            $reaction = 'n'; // n = none
        }

        VideoReaction::updateOrCreate($condition, ['reaction' => $reaction]);

        return Helper::ApiResponse('', [
            'like' => $video_reaction_query->first()->reaction === 'l',
            'dislike' => $video_reaction_query->first()->reaction === 'd',
            'video_likes_count' => $query->first()->likes_count,
        ]);
    }


}
