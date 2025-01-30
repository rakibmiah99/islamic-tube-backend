<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Http\Resources\VideoDetailsResource;
use App\Http\Resources\VideoResource;
use App\Models\Comment;
use App\Models\Video;
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


    function videoDetail($slug)
    {
        $video = Video::where('slug', $slug)
            ->withSum('watch_counts', 'watch_count')
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


}
