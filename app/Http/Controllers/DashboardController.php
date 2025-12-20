<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\News;
use App\Models\Announcement;
use App\Models\Visit;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats Summary
        $totalArticles = Article::count();
        $totalNews = News::count();

        // Top Content
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();
        $popularNews = News::orderBy('views', 'desc')->take(5)->get();

        // Active Announcements
        $announcements = Announcement::where('expires_at', '>=', now())
            ->orderBy('expires_at', 'asc')
            ->take(5)
            ->get();

        // Monthly Visits Data for Chart (last 12 months)
        $chartData = [];
        $chartLabels = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = Visit::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            
            $chartData[] = $count;
            $chartLabels[] = $month->translatedFormat('M');
        }

        return view('dashboard.index', compact(
            'totalArticles',
            'totalNews',
            'popularArticles',
            'popularNews',
            'announcements',
            'chartData',
            'chartLabels'
        ));
    }
}
