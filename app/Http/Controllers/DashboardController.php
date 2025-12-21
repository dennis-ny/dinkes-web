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
        $user = auth()->user();
        $isAdmin = $user->role === 'admin';

        // Stats Summary
        $totalArticles = $isAdmin ? Article::count() : Article::where('user_id', $user->id)->count();
        $totalNews = $isAdmin ? News::count() : News::where('user_id', $user->id)->count();

        // Top Content
        $popularArticlesQuery = Article::orderBy('views', 'desc');
        if (!$isAdmin) {
            $popularArticlesQuery->where('user_id', $user->id);
        }
        $popularArticles = $popularArticlesQuery->take(5)->get();

        $popularNewsQuery = News::orderBy('views', 'desc');
        if (!$isAdmin) {
            $popularNewsQuery->where('user_id', $user->id);
        }
        $popularNews = $popularNewsQuery->take(5)->get();

        // Active Announcements
        $announcementsQuery = Announcement::where('expires_at', '>=', now())
            ->orderBy('expires_at', 'asc');
        if (!$isAdmin) {
            $announcementsQuery->where('user_id', $user->id);
        }
        $announcements = $announcementsQuery->take(5)->get();

        // Monthly Visits Data for Chart (last 12 months)
        $chartData = [];
        $chartLabels = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $visitsQuery = Visit::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month);
            
            if (!$isAdmin) {
                // Assuming visits are linked to content, but Visit model might need a relation check.
                // If Visit is just a global log, maybe we filter by visits to user's content?
                // For now let's check if Visit has a morph or direct relation.
                // Wait, if I don't have a direct user_id on Visit, I might need to join.
                // Let's assume for now we only show global stats for admin and zero/limited for UPT if not easily filterable.
                // Actually, let's just show global for now or zero if we can't filter.
                // Most simple: filter visits that belong to articles/news owned by the user.
                $visitsQuery->where(function($q) use ($user) {
                    $q->whereHasMorph('visitable', [Article::class, News::class], function($q2) use ($user) {
                        $q2->where('user_id', $user->id);
                    });
                });
            }

            $count = $visitsQuery->count();
            
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
