@extends('layouts.layout')
@section('content')
    <h3 class="text-center">Новость</h3>
    <div class="card">
        <form action="/articles/{{$data->id}}" method="post">
            @method('DELETE')
            @csrf
            <div class="card-body">
                <h5 class="card-title">{{$data->name}} ({{$data->date}})</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{$data->shortDesc}}</h6>
                <p class="card-text">{{$data->desc}}</p>
                <a href="/articles/{{$data->id}}/edit" class="btn btn-info">Редактировать</a>
                <button type="submit" class="btn btn-warning">Удалить</button>
            </div>
        </form>
    </div>
    <h3 class="text-center">Комментарии</h3>
    @isset($_GET['result'])
        @if($_GET['result'])
            <div class="alert alert-primary" role="alert">
                <span>Ваш комментарий отправлен на модерацию!</span>
            </div>
        @endif
    @endisset
    <div class="card">
        @foreach($comments as $comment)
            <div class="card-body">
                <h5 class="card-title">{{$comment->title}} </h5> <h4 class="card-title">({{$comment->created_at}})</h4>
                <p class="card-text">{{$comment->text}}</p>
                @can('manage-comment', $comment)
                    <a href="/comment/{{$comment->id}}/edit" class="btn btn-secondary">Редактировать</a>
                    <a href="/comment/{{$comment->id}}/delete" class="btn btn-secondary">Удалить</a>
                @endcan
            </div>
        @endforeach
    </div>
    </br>
    <h5 class="text-center">Добавить комментарий</h5>
    @if($errors->any())
        <div class="alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>
                        {{$error}}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/comment" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{$data->id}}">
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Title</label>
            <input type="text" class="form-control" id="exampleInputPassword1" name="title">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Text</label>
            <textarea name="text" class="form-control" id="description" cols="30" rows="10"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
