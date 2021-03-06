@extends('layouts.layout')

@section('title', 'Connexion')

@section('content')
    @if ($errors)
        <ul>
            @foreach($errors as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif

    <form id="addUser" action="/user/login" method="POST">
        <label for="login">Identifiant</label>
        <input type="text" name="login" id="login"><br>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password"><br>
        <input type="submit" value="Login">
    </form>
@endsection

