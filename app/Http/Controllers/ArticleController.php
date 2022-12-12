<?php

namespace App\Http\Controllers;

use App\Events\NewArticle;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\NewArticleNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentPage = request('page');
        $articles = Cache::remember('articles:all'.$currentPage, 2000, function(){
            return Article::latest()->paginate(5);
        });
        return view('articles.index', ['data' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Отображение шаблона на создание записи
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    // Создание записи
    public function store(Request $request)
    {
        Cache::forget('articles:all');

        $request->validate([
            'name' => 'required',
            'annotation' => 'required'
        ]);

        $article = new Article();
        $article->date = request('date');
        $article->name = request('name');
        $article->shortDesc = request('annotation');
        $article->desc = request('description');
        $result = $article->save();
        $users = User::where('id', '!=', auth()->id())->get();
        if ($result){
            Notification::send($users, new NewArticleNotify($article));
            NewArticle::dispatch($article);
        }
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    // Получение по id
    public function show($id)
    {
        if (isset($_GET['notify'])){
            auth()->user()->notifications()->where('id', $_GET['notify'])->first()->markAsRead();
        }
        $article = Cache::rememberForever('article:'.$id.'_show', function()use($id){
            return Article::FindOrFail($id);
        });
        $comments = Comment::where([
            ['article_id',$id],
            ['accept', 1]
        ])->latest()->get();
        return view('articles.show', ['data'=>$article, 'comments'=>$comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    // Отображение шаблона на редактирование
    public function edit($id)
    {
        $article = Article::FindOrFail($id);
        return view('articles.edit', ['data'=>$article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    // Обновление записи
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'name' => 'required',
            'annotation' => 'required',
        ]);
        $article = Article::FindOrFail($id);
        $article->date = request('date');
        $article->name = request('name');
        $article->shortDesc = request('annotation');
        $article->desc = request('description');
        $article->save();
        if ($article->save()) Cache::forget('article:'.$id.'_show');
        return redirect('/articles/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    // Удаление записи
    public function destroy($id)
    {
        Cache::flush();
        $article = Article::FindOrFail($id);
        Comment::where('article_id', $id)->delete();
        $article->delete();
        return redirect('/');
    }
}
