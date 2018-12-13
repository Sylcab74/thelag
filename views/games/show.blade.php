@extends('layouts.test')

@section('title', 'Le titre')


@section('content')

    <div class="box">
        {{ $game->id }}
        {{ $game->name }}
        {{ $game->type }}
        <img src="{{ $game->picture }}" alt="">
    </div>
@endsection