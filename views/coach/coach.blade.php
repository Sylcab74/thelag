@extends('layouts.test')

@section('title', 'Le titre')

@section('content')
    <h1>{{$user->login}}</h1>
    @component('components.calendar') @endcomponent
@endsection