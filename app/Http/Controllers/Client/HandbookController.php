<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Admins\Article;

class HandbookController extends Controller
{
    public function index()
    {
        $articles = Article::where('status', 'active')->latest()->paginate(6); // Phân trang 6 bài viết
        return view('client.pages.handbook', compact('articles'));
    }

    public function show($slug)
    {
        $articles = Article::where('slug', $slug)->where('status', 'active')->firstOrFail();
        return view('client.pages.handbook_detail', compact('article'));
    }
}

