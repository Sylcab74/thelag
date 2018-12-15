@extends('layouts.test')

@section('title', 'The Lag - Jeux')


@section('content')
    <h1>JEUX</h1>
    <div class="box">
        <ul>
        @forelse ($games as $game)
            @component('components.gamecard',['game'=>$game])
            @endcomponent
        @empty
            <p>No game disponible</p>
        @endforelse
        </ul>
    </div>
@endsection