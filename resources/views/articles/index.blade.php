@extends('layouts.layout')
@section('content')
    <h2>Articles list</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Image</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $article)
            <tr>
                                <th scope="row">{{$article['date']}}</th>
                                <td><a href="/articles/{{$article->id}}">{{$article->name}}</a></td>
                                <td>{{$article['desc']}}</td>
                                <td><a href="/gallery/{{$article['full_image']}}">
                                        <img src="{{URL::asset($article['preview_image'])}}"
                                             alt="" height="100" width="100">
                                    </a></td>
{{--                <th scope="row">{{$article['date']}}</th>--}}
{{--                <td>{{$article['name']}}</td>--}}
{{--                <td>{{$article['desc']}}</td>--}}
{{--                <td><a href="/gallery/{{$article['full_image']}}">--}}
{{--                        <img src="{{URL::asset($article['preview_image'])}}"--}}
{{--                             alt="" height="100" width="100">--}}
{{--                    </a>--}}
{{--                </td>--}}
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$data->links()}}
@endsection
