@extends('layouts.test')

@section('title', 'Jeux')


@section('content')
    <h1>JEUX</h1>
    <div class="box">
        <ul>
        @forelse ($games as $game)
            @component('components.gamecard',['game'=>$game])
            @endcomponent
        @empty
            <p>Aucun jeu disponible</p>
        @endforelse
        </ul>
    </div>
@endsection