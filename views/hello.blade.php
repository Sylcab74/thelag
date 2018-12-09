@extends('layouts.test')

@section('title', 'Le titre')


@section('content')

    <div class="box">

        @forelse ($games as $game)
            <li>{{ $game->name }} - {{$game->type}}</li>
        @empty
            <p>No users</p>
        @endforelse
    </div>
@endsection