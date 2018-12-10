@extends('layouts.test')

@section('title', 'Le titre')


@section('content')

    <div class="box">
        <ul>
        @forelse ($users as $user)
            <li>{{ $user->login }} - {{$user->firstname}} - {{$user->lastname}} - {{$user->email}}</li>
        @empty
            <p>No users</p>
        @endforelse
        </ul>
    </div>
@endsection