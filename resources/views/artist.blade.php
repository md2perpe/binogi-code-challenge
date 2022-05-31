<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Code Challenge</title>
    <style>
    </style>
</head>
<body>
<div class="flex-center full-height">
    <div><img src="{{$images[0]['url']}}"></div>
    <h1>{{$name}}</h1>
    <p>Genres: {{join(', ', $genres)}}</p>
    <p>Followers: {{$followers['total']}}</p>
</div>
</body>
</html>
