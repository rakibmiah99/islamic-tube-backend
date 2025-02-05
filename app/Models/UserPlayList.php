<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPlayList extends Model
{
    //

    protected $guarded = [];

    public function videos(){
        return $this->hasManyThrough(Video::class, UserPlayListVideo::class, 'user_play_list_id', 'id', 'id', 'video_id');
    }
}
