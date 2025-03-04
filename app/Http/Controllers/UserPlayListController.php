<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPlalistVideoAddRequest;
use App\Models\UserPlayList;
use App\Models\UserPlayListVideo;
use App\Utils\Helper;
use Illuminate\Http\Request;

class UserPlayListController extends Controller
{

    public function get()
    {
        $video_id = \request()->get('video_id');
        $user_id = auth()->id();
        $query = UserPlayList::where('user_id', $user_id);

        if($video_id){
            $query->with(['play_list_videos' => function ($query) use ($video_id) {
                if ($video_id) {
                    $query->where('video_id', $video_id);
                }
            }]);
        }
        else{
            $query->withCount(['play_list_videos as total_videos']);
        }

        $data = $query->get()->map(function ($playlist) use ($video_id){
            $new_data = [
                'id' => $playlist->id,
                'user_id' => $playlist->user_id,
                'name' => $playlist->name,
            ];


            if ($video_id){
                 $is_in_list =  (boolean) $playlist->play_list_videos->isNotEmpty();
                $new_data['video_in_list'] = $is_in_list;
            }
            else{
                $new_data['thumbnail'] = $playlist->videos?->first()?->thumbnail;
                $new_data['total_videos'] = $playlist->total_videos;
            }

            return $new_data;
        });
        return Helper::ApiResponse('', $data);
    }

    public function create(Request $request)
    {
        $name = $request->input('name');
        $user_id = auth()->id();
        $play_list = new UserPlayList();
        $play_list->name = $name;
        $play_list->user_id = $user_id;

        if ($play_list->where(['name' => $name, 'user_id' => $user_id])->exists()) {
            return Helper::ApiResponse('playlist already exist!', [], 409, false);
        }
        else{
            $play_list->save();
            return Helper::ApiResponse('created successfully', $play_list);
        }
    }

    public function delete($id)
    {
        $user_id = auth()->id();
        $data = UserPlayList::where('user_id', $user_id)->findOrFail($id);
        $data->delete();
        return Helper::ApiResponse('deleted successfully', $data);
    }

    public function update($id, Request $request)
    {
        $name = $request->input('name');
        $user_id = auth()->id();
        $data = UserPlayList::where('user_id', $user_id)->findOrFail($id);

        if($data->name != $name){
            $data->name = $name;
            $data->save();
        }

        return Helper::ApiResponse('updated successfully', $data);
    }


    public function getVideos($id)
    {
        $user_id = auth()->id();
        $playlist = UserPlayList::where('user_id', $user_id)->findOrFail($id);
        return $data = \App\Http\Resources\UserPlayListDetailsResource::make($playlist);
    }



    public function addVideoInPlayList(UserPlalistVideoAddRequest $request)
    {
        $user_id = auth()->id();
        $video_id = $request->input('video_id');
        $playlist_id = $request->input('playlist_id');
        $playlist_video = new UserPlayListVideo();
        $condition = [
            'user_id' => $user_id,
            'user_play_list_id' => $playlist_id,
            'video_id' => $video_id
        ];

        if($playlist_video->where($condition)->exists()){
            $playlist_video->where($condition)->delete();

            return Helper::ApiResponse('video removed from list successfully!');
        }

        try {
            $playlist_video->insert($condition);
            return Helper::ApiResponse('video inserted in list successfully', $playlist_video->where($condition)->first());
        }
        catch (\Exception $exception){
            return Helper::ApiResponse('error', [], 500, false);
        }
    }
}
