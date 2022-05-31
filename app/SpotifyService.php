<?php

namespace App;

use GuzzleHttp\Client;

class SpotifyService
{
    static $CLIENT_ID = 'xxx';
    static $CLIENT_SECRET = 'xxx';

    private function getAccessToken()
    {
        $client = new Client();

        $res = $client->request('POST', 'https://accounts.spotify.com/api/token', [
            'auth' => [ SpotifyService::$CLIENT_ID, SpotifyService::$CLIENT_SECRET ],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ],
        ]);

        return json_decode($res->getBody())->access_token;
    }

    public function search($query)
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

    public function artist($artist_id)
    {
        $access_token = $this->getAccessToken();

        $client = new Client();
        $res = $client->request('GET', "https://api.spotify.com/v1/artists/{$artist_id}", [
            'headers' => [
                'Authorization' => "Bearer {$access_token}",
            ],
        ]);

        return json_decode($res->getBody(), true);
    }

    public function album($album_id)
    {
        $access_token = $this->getAccessToken();

        $client = new Client();
        $res = $client->request('GET', "https://api.spotify.com/v1/albums/{$album_id}", [
            'headers' => [
                'Authorization' => "Bearer {$access_token}",
            ],
        ]);

        return json_decode($res->getBody(), true);
    }

    public function track($track_id)
    {
        $access_token = $this->getAccessToken();

        $client = new Client();
        $res = $client->request('GET', "https://api.spotify.com/v1/tracks/{$track_id}", [
            'headers' => [
                'Authorization' => "Bearer {$access_token}",
            ],
        ]);

        return json_decode($res->getBody(), true);
    }
}
