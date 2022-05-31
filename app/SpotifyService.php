<?php

namespace App;

use GuzzleHttp\Client;

class SpotifyService
{
    private $client_id;
    private $client_secret;

    public function __construct()
    {
        $this->client_id = env('SPOTIFY_CLIENT_ID');
        $this->client_secret = env('SPOTIFY_CLIENT_SECRET');
    }

    private function getAccessToken()
    {
        $client = new Client();

        $res = $client->request('POST', 'https://accounts.spotify.com/api/token', [
            'auth' => [ $this->client_id, $this->client_secret ],
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
        return $this->getEntity('artist', $artist_id);
    }

    public function album($album_id)
    {
        return $this->getEntity('album', $album_id);
    }

    public function track($track_id)
    {
        return $this->getEntity('track', $track_id);
    }

    private function getEntity($type, $id)
    {
        $access_token = $this->getAccessToken();

        $client = new Client();
        $res = $client->request('GET', "https://api.spotify.com/v1/{$type}s/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$access_token}",
            ],
        ]);

        return json_decode($res->getBody(), true);
    }
}
