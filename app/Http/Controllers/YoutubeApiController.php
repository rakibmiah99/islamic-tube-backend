<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\YoutubeChannel;
use App\Models\YoutubePlayList;
use App\Utils\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class YoutubeApiController extends Controller
{

    public string $user_name;
    public string $api_key;
    function __construct()
    {
        $this->api_key = 'AIzaSyCAKqnG_e9vqrmAhOhFYy9c5dzBm2328Z0';
        $this->user_name = '';
    }


    public function run()
    {
        $channels = YoutubeChannel::where('is_finished', '=', false)->get(['id', 'channel_id']);

        for($i = 0; $i < count($channels); $i++){
            $channel = $channels[$i];
            $next_page_token = true;
            while($next_page_token){
                $play_list = $this->getPlayList($channel->channel_id, $next_page_token);
                $next_page_token = $play_list->next_page_token;
                $playlist_ids = $play_list->ids;
                foreach($playlist_ids as $playlist_id){
                    if(YoutubePlayList::where('playlist_id', $playlist_id)->count() == 0){
                        YoutubePlayList::insert([
                            'playlist_id' => $playlist_id,
                            'youtube_channel_id' => $channel->id,
                        ]);
                    }
                }
            }

            $channel->update(['is_finished' => true]);
        }
    }


    public function runPlayList()
    {
        $play_lists = YoutubePlayList::where('is_finished', '=', false)->get(['id', 'playlist_id']);

        for($i = 0; $i < count($play_lists); $i++){
            $play_list = $play_lists[$i];
            $next_page_token = true;
            while($next_page_token){
                $play_list_items = $this->getPlayListItems($play_list->playlist_id, $next_page_token);
                $next_page_token = $play_list_items->next_page_token;
                $videos = $play_list_items->videos;
                foreach($videos as $video){
                    if(Video::where('slug', $video['slug'])->count() == 0){
                        Video::insert($video);
                    }
                }
            }

            $play_list->update(['is_finished' => true]);
        }
    }


    public function getPlayList($channel_id, $next_page_token)
    {

        $response = Http::get("https://www.googleapis.com/youtube/v3/playlists", [
            'channelId' => $channel_id,
            'key' => $this->api_key,
            'maxResults' => 50,
            'pageToken' => $next_page_token === true ? '' : $next_page_token,
        ]);

        if ($response->ok()) {
            $result = $response->json();
            $next_page_token = $result['nextPageToken'] ?? false;
            $items = collect($result['items']);
            $play_list_ids = $items->pluck('id');

            return (object)[
                'next_page_token' => $next_page_token,
                'ids' => $play_list_ids
            ];
        }
        else{
            return (object)[
                'next_page_token' => false,
                'ids' => [],
                'message' => 'error found!'
            ];
        }

    }

    public function getChanel($chanel_id)
    {
        $response = Http::get("https://www.googleapis.com/youtube/v3/channels", [
            'id' => $chanel_id,
            'key' => $this->api_key,
        ]);
        if ($response->ok()) {
            dd($response->json());
        }
        dd($response);
    }


    public function getPlayListItems($playlist_id, $next_page_token = true)
    {
        $response = Http::get("https://www.googleapis.com/youtube/v3/playlistItems", [
            'playlistId' => $playlist_id,
            'key' => $this->api_key,
            'maxResults' => 50,
            'part' => 'snippet,contentDetails',
            'pageToken' => $next_page_token === true ? '' : $next_page_token,
        ]);
        if ($response->ok()) {
            $result = $response->json();
            $next_page_token = $result['nextPageToken'] ?? false;
            $items = collect($result['items']);
            $snippets = $items->pluck('snippet');

            $videos = $snippets->select(['title', 'thumbnails', 'resourceId', 'publishedAt'])->where('title', '!=', 'Private video')->map(function ($item) {
                $item = (object)$item;
                return [
                    'title' => $item->title,
                    'slug' => Str::slug($item->title),
                    'video_id' => $item->resourceId['videoId'],
                    'published_at' => date('Y-m-d H:i:s', strtotime($item->publishedAt)),
                    'thumbnail' => $item->thumbnails['maxres']['url'] ?? 'http://admin.programmingwithrakib.com/files/675834a784299.png',
                    'thumbnail_md' => $item->thumbnails['standard']['url'] ?? null,
                    'thumbnail_sm' => $item->thumbnails['medium']['url'] ?? null,
                    'provider' => 'youtube'
                ];
            });
            return (object)[
                'next_page_token' => $next_page_token,
                'videos' => $videos
            ];
        }
        return (object)[
            'next_page_token' => false,
            'videos' => [],
            'message' => 'error found!'
        ];
    }

    public function getChannelId(Request $request){
        $chanel_name = $request->input('channel_name', 'ProgrammingWithRakib365');
        $chanel_id = $request->input('channel_id', 'UCN6sm8iHiPd0cnoUardDAnw'); //jamuna
        $play_list_id = $request->input('play_list_id', 'PLBCF2DAC6FFB574DE'); //
        $chanel_id = $request->input('channel_id', 'UCEjAA1tFfXDRG4ovkD-dQmQ'); //pwr
//        $url = "https://www.googleapis.com/youtube/v3/channels?part=id&forUsername={$chanel_name}&key={$this->api_key}";
//        $url = "https://www.googleapis.com/youtube/v3/videos?id=7lCDEYXw3mM&key={$this->api_key}&part=snippet,contentDetails,statistics,status";

//        $url = "https://www.googleapis.com/youtube/v3/playlists?channelId={$chanel_id}&key={$this->api_key}";
        $url = "https://www.googleapis.com/youtube/v3/playlistItems?playlistId={$play_list_id}&key={$this->api_key}&part=snippet,contentDetails";


        $response = Http::get("https://www.googleapis.com/youtube/v3/playlistItems", [
            'playlistId' => $play_list_id,
            'key' => $this->api_key,
            'part' => 'snippet,contentDetails',
        ]);
        if ($response->ok()) {
            dd($response->json());
        }
        dd($response);

    }
}
