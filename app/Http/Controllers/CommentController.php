<?php

namespace App\Http\Controllers;

use App\Jobs\NewJob;
use App\Mail\CommentMail;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::where('accept', null)->latest()->paginate(10);
        return view('comments.index', ['comments' => $comments]);
    }

    public function accept(Comment $comment)
    {
        $comment->accept = 1;
        $comment->save();
        return redirect()->back();
    }

    public function reject(Comment $comment)
    {
        $comment->accept = 0;
        $comment->save();
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'text' => 'required',
        ]);

        $comment = new Comment();
        $comment->title = request('title');
        $comment->text = $request->text;
        $comment->article()->associate(request('id'));
        $result = $comment->save();
        $article = Article::FindOrFail(request('id'));
        NewJob::dispatch($article);
        return redirect()->route('articles.show', ['article' => request('id'), 'result' => $result]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        Gate::authorize('manage-comment', $comment);
        return view('comments.edit', ['comment' => $comment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('manage-comment', $comment);

        $request->validate([
            'title' => 'required',
            'text' => 'required',
        ]);
        $comment->title = request('title');
        $comment->text = request('text');
        $comment->save();
        $article = Article::FindOrFail($comment->article_id);
        $msg = new CommentMail($article, $comment);
        Mail::send($msg);
        return redirect()->route('articles.show', ['article' => $comment->article_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        Gate::authorize('manage-comment', $comment);

        $comment->delete();
        return redirect()->route('articles.show', ['article' => $comment->article_id]);

    }
}
