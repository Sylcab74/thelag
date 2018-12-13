@extends('layouts.test')

@section('title', 'The Lag - Jeux')


@section('content')
    <h1>JEUX</h1>
    <div class="box">
        <ul>
        @forelse ($games as $game)
            <li class="li_game"><img class='game' src={{ $game->picture}} /> <br> {{ $game->name }} - {{$game->type}} </li>
        @empty
            <p>No game disponible</p>
        @endforelse
        </ul>
    </div>
@endsection