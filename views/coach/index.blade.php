@extends('layouts.test')

@section('title', 'Coachs')


@section('content')
    <div class="box">
        <ul>
            @forelse ($users as $user)
            <a href="/coach/show/{{ $user->id }}">
                <li class="li_game">
                    
                        <img class="img_game" src="{{ $user->picture }}" alt="{{ $user->login}}" /> <br> 
                        <h2>{{$user->login }}</h2>
                        <p>{{$user->price }}€/h</p>
                    
                </li>
            </a>
            @empty
                <p>Aucun utilisateur n'a été créé</p>
            @endforelse
        </ul>
    </div>
@endsection