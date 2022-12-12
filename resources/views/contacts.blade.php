@extends('layouts.layout')
@section('content')
    <h1>Страница "Контакты"</h1>
    <p class="text-uppercase">{{$data['name']}}</p>
    <p class="text-capitalize">{{$data['address']}}</p>
    <p class="text-lowercase">{{$data['phone']}}</p>
    <p class="text-lowercase">{{$data['email']}}</p>
@endsection
