<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AlQuranController extends Controller
{
    public function request()
    {
        return Http::baseUrl('http://api.alquran.cloud/v1');
    }

    public function index()
    {
        $response = $this->request()->get('/edition/language/bn');
        $data = [];
        if ($response->status() == 200) {
            $data = $response->json()['data'];
        }

        return $data;
        dd($data);
    }
}
