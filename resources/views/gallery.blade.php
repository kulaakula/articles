@extends('layouts.layout')
@section('content')
    <h2>{{$image_url}}</h2>
    <img src="{{URL::asset($image_url)}}" alt="">
@endsection
