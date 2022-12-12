<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $data = json_decode(file_get_contents(public_path().'/articles.json'), true);
        return view('articles.index', ['data' => $data]);
    }

    public function about()
    {
        return view('about');
    }

    public function contacts()
    {
        $data = [
            'name' => 'МосПолиТех',
            'address' => 'Большая Семёновская, д. 38',
            'phone' => '8(495)432-2323',
            'email' => 'mail@mospolytech.ru',
        ];
        return view('contacts', ['data' => $data]);
    }

    public function gallery($image_url){
        return view('gallery', ['image_url' => $image_url]);
    }
}
