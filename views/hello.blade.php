@extends('layouts.test')

@section('title', 'Le titre')


@section('content')

    <div class="box">
        <ul>
        @forelse ($games as $game)
            <li>{{ $game->name }} -{{$game->type}}</li>
        @empty
            <p>No users</p>
        @endforelse
        </ul>
    </div>
@endsection