<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Utils\Helper;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function allVideos(Request $request)
    {
        $limit = $request->input('limit', 24);
        $offset = $request->input('offset', 0);


        $video_query = Video::limit($limit)->offset($offset)->get([
            'slug',
            'title',
            'thumbnail',
            'published_at',
        ]);

        $next_load = $offset + $limit;
        $next_load_url = route('all-videos', ['offset' => $next_load]);
        return Helper::ApiResponse('', [
            'next_load' => $next_load_url,
            'data' => $video_query
        ]);
    }
}
