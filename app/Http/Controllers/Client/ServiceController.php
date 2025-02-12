<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Admins\CategoryTour;
use App\Models\Admins\Categoty_tour;
use App\Models\Article;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $categotyTour = CategoryTour::all();
        $article = Article::with('user')->limit(6)->get();
        return view('client.pages.service', compact('categotyTour', 'article'));
    }
    public function show(string $id, Request $request)
    {
        $showArticle = Article::find($id);
        // dd($showArticle);
        $relatedArticles = Article::latest()->take(5)->get();


        return view('client.pages.detailHandbook', compact('showArticle', 'relatedArticles'));
    }
}
