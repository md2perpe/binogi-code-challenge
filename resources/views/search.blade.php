<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Code Challenge</title>
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: sans-serif;
            height: 100vh;
            margin: 50px;
        }

        .full-height {
            height: 100vh;
        }

        .result {
        }

        li {
            list-style-type: none;
        }

        ul {
            display: grid;
            grid-template-columns: auto auto auto auto;
            row-gap: 20px;
        }
    </style>
</head>
<body>
<div class="full-height">
    <div class="result">
        <p>Your Search Term Was: <b>{{$searchTerm}}</b></p>

        <div style="border: 1px solid black">
            <h2>Artists</h2>
            @if (count($artists) > 0)
            <ul>
                @foreach ($artists as $artist)
                <li>
                    <a href="/artist/{{$artist->id}}">
                        <img src="{{$artist->images[0]->url}}" width="200" height="200"><br>
                        <b>{{$artist->name}}</b>
                    </a>
                </li>
                @endforeach
            </ul>
            @else
            <p>No artists found</p>
            @endif
        </div>

        <div style="border: 1px solid black">
            <h2>Albums</h2>
            @if (count($albums) > 0)
            <ul>
                @foreach ($albums as $album)
                <li>
                    <a href="/album/{{$album->id}}">
                        <img src="{{$album->images[0]->url}}" width="200" height="200"><br>
                        <b>{{$album->name}}</b>
                    </a>
                </li>
                @endforeach
            </ul>
            @else
            <p>No albums found</p>
            @endif
        </div>

        <div style="border: 1px solid black">
            <h2>Tracks</h2>
            @if (count($tracks) > 0)
            <ul>
                @foreach ($tracks as $track)
                <li>
                    <a href="/track/{{$track->id}}">
                        <img src="{{$track->album->images[0]->url}}" width="200" height="200"><br>
                        <b>{{$track->name}}</b>
                    </a>
                </li>
                @endforeach
            </ul>
            @else
            <p>No tracks found</p>
            @endif
        </div>

    </div>
</div>
</body>
</html>
