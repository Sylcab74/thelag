@extends('layouts.test')

@section('title', 'Coachs')


@section('content')
    <div class="box">
        <ul>
            @forelse ($users as $user)
                <li><a href="/coach/show/{{ $user->id }}">{{ $user->firstname }}</a></li>
            @empty
                <p>Aucun utilisateur n'a été créé</p>
            @endforelse
        </ul>
    </div>
@endsection