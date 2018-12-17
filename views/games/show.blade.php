@extends('layouts.test')

@section('title', $game->name)

@section('content')
    <h1>{{ $game->name }}</h1>
    <p>{{ $description }}</p>
    <button>Ajouter à ses jeux</button>
@endsection

@section('javascript')
@endsection