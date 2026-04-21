<?php

namespace App\Http\Controllers;

use App\Services\PaperSearchService;

class DashboardController extends Controller
{
    public function index(PaperSearchService $service)
    {
        $stats = $service->getDashboardStats();

        $trending = $service->getTrendingPapers();

        $cited = $service->getMostCitedPapers();

        $topics = $service->getTrendingTopics();

        return view('dashboard', compact(
            'stats',
            'trending',
            'cited',
            'topics'
        ));
    }
}