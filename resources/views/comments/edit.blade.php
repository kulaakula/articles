@extends('layouts.layout')
@section('content')

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

    <form action="/comment/{{$comment->id}}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Title</label>
            <input type="text" class="form-control" id="exampleInputPassword1" name="title" value="{{$comment->title}}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Text</label>
            <textarea name="text" class="form-control" id="description" cols="30" rows="10">{{$comment->text}}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
