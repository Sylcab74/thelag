@extends('layouts.test')

@section('title', 'Le titre')


@section('content')

    <div class="box">

        <h1>{{ $game->name }}</h1>
        <ul>
            <li><strong>nom : </strong>{{ $game->name }}</li>
            <li><strong>type : </strong>{{ $game->type }}</li>
        </ul>
    </div>
@endsection