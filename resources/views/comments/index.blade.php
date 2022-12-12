@extends('layouts.layout')
@section('content')

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Article</th>
            <th scope="col">Title</th>
            <th scope="col">Text</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($comments as $comment)
            <tr>
                <th scope="row">{{$comment->created_at}}</th>
                <td>{{App\Models\Article::where('id', $comment->article_id)->value('name')}}</td>
                <td>{{$comment->title}}</td>
                <td>{{$comment->text}}</td>
                <td><a href="/comment/{{$comment->id}}/accept" class="btn">Принять</a>
                    <a href="/comment/{{$comment->id}}/reject" class="btn">Отклонить</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$comments->links()}}
@endsection
