<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('urutan', 'asc')->get();

        $latestNews = \App\Models\News::latest()->take(5)->get();
        $popularNews = \App\Models\News::orderBy('views', 'desc')->take(5)->get();

        $latestArticles = \App\Models\Article::latest()->take(5)->get();
        $popularArticles = \App\Models\Article::orderBy('views', 'desc')->take(5)->get();

        $announcements = \App\Models\Announcement::active()->latest()->get();

        return view('public.home', compact('sliders', 'latestNews', 'popularNews', 'latestArticles', 'popularArticles', 'announcements'));
    }
}
