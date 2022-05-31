<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SearchController extends Controller
{
    public function index()
    {
        return view('index');
    }


    public function search(Request $request)
    {
        $query = $request->get('query');

        return view('search', $this->doSearch($query) + [ 'searchTerm' => $query ]);
    }


    public function artist(Request $request, $artist_id)
    {
        $access_token = $this->getAccessToken();

        $client = new Client();
        $res = $client->request('GET', "https://api.spotify.com/v1/artists/{$artist_id}", [
            'headers' => [
                'Authorization' => "Bearer {$access_token}",
            ],
        ]);
        return view('artist', json_decode($res->getBody(), true));
    }


    public function album(Request $request, $album_id)
    {
        $access_token = $this->getAccessToken();

        $client = new Client();
        $res = $client->request('GET', "https://api.spotify.com/v1/albums/{$album_id}", [
            'headers' => [
                'Authorization' => "Bearer {$access_token}",
            ],
        ]);
        return view('album', json_decode($res->getBody(), true));
    }


    private function getAccessToken()
    {
        $client = new Client();

        $res = $client->request('POST', 'https://accounts.spotify.com/api/token', [
            'auth' => [ 'xxx', 'xxx' ],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ],
        ]);

        return json_decode($res->getBody())->access_token;
    }

    private function doSearch($query)
    {
        $access_token = $this->getAccessToken();

        $client = new Client();
        $res = $client->request('GET', 'https://api.spotify.com/v1/search', [
            'headers' => [
                'Authorization' => "Bearer {$access_token}",
            ],
            'query' => [
                'q' => $query,
                'type' => 'artist,album,track',
            ]
        ]);

        $data = json_decode($res->getBody());

        return [
            'artists' => $data->artists->items,
            'albums'  => $data->albums->items,
            'tracks'  => $data->tracks->items,
        ];
    }
}
