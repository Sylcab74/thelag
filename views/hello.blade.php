@extends('layouts.test')

@section('title', 'Le titre')


@section('content')

    <div class="box">

        <h1>{{ $distributeur->nom }}</h1>
        <ul>
            <li><strong>nom : </strong>{{ $distributeur->nom }}</li>
            <li><strong>telephone : </strong>{{ $distributeur->telephone }}</li>
            <li><strong>adresse : </strong> {{$distributeur->adresse}} {{ $distributeur->cpostale }} {{ $distributeur->ville }}</li>
            <li><strong>pays : </strong>{{ $distributeur->pays }}</li>
        </ul>
    </div>
@endsection