<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SpotifyService;

class SearchController extends Controller
{
    public function index()
    {
        return view('index');
    }


    public function search(Request $request, SpotifyService $spotify)
    {
        $query = $request->get('query');
        return view('search', $spotify->search($query) + [ 'searchTerm' => $query ]);
    }


    public function artist($artist_id, SpotifyService $spotify)
    {
        return view('artist', $spotify->artist($artist_id));
    }

    public function album($album_id, SpotifyService $spotify)
    {
        return view('album', $spotify->album($album_id));
    }

    public function track($track_id, SpotifyService $spotify)
    {
        return view('track', $spotify->track($track_id));
    }
}
