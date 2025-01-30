<?php

namespace App\Models;

use App\Utils\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;


    public function watch_counts()
    {
        return $this->hasMany(VideoWatchCount::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'video_tags', 'video_id', 'tag_id', 'id', 'id')->select('tags.id', 'tags.name');
    }


    public static function relatedVideosData($tag_ids, $skip_video_id, $offset = 0, $limit = 15)
    {
        $videos = Video::withSum('watch_counts', 'watch_count')
        ->where('id', '!=', $skip_video_id)
        ->whereHas('tags', function ($query) use ($tag_ids) {
            $query->whereIn('tags.id', $tag_ids);
        })->limit($limit)->offset($offset)->get();


        return [
            'data' => $videos,
            'token' => self::RelatedVideoTokenPack($tag_ids,$limit + $offset, $skip_video_id),
        ];
    }


    static public function RelatedVideoTokenPack($tag_ids, $next_offset = 0, $video_id)
    {
        $tags = json_encode($tag_ids);
        $meta_data = $tags . "@" . $next_offset."@".$video_id;
        //make token
        $token =  Helper::OpenSSLEncrypt($meta_data);

        // Replace /  with `--`
        $token = str_replace('/', '--', $token);

        return $token;
    }

    //generate token for next load related videos
    static public function RelatedVideoTokenUnPack($token)
    {
        // replace -- with for base form of token/
        $token = str_replace('--', '/', $token);


        $token = Helper::OpenSSLDecrypt($token);
        $meta_data = explode("@", $token);
        return (object)[
            'tags' => json_decode($meta_data[0]),
            'next_offset' => (integer)$meta_data[1],
            'video_id' => (integer)$meta_data[2],
        ];
    }

    //decrypt token for next load related videos
    static function LoadMoreCommentPack($video_id, $offset = 0)
    {
        $limit = 15;
        $next_offset = $limit + $offset;

        $meta_data = $video_id . "@" . $next_offset."@".$limit;
        //make token
        $token =  Helper::OpenSSLEncrypt($meta_data);

        // Replace /  with `--`
        return $token = str_replace('/', '--', $token);
    }


    //encrypt token for next load comments
    static function LoadMoreCommentUnPack($token)
    {
        $token = str_replace('--', '/', $token);


        $token = Helper::OpenSSLDecrypt($token);
        $meta_data = explode("@", $token);
        return (object)[
            'video_id' => json_decode($meta_data[0]),
            'next_offset' => (integer)$meta_data[1],
            'limit' => (integer)$meta_data[2],
        ];
    }
}
