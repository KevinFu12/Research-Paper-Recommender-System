<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Services\PaperSearchService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PaperController extends Controller
{
    public function index(Request $request, PaperSearchService $searchService)
    {
        $results = [];

        if ($request->filled('q')) {

            $queryResults = $searchService->search($request->q);

            $allResults = iterator_to_array($queryResults);

            $page = LengthAwarePaginator::resolveCurrentPage();
            $perPage = $request->get('limit', 10);

            $items = array_slice($allResults, ($page - 1) * $perPage, $perPage);

            $results = new LengthAwarePaginator(
                $items,
                count($allResults),
                $perPage,
                $page,
                [
                    'path' => request()->url(),
                    'query' => request()->query()
                ]
            );
        }

        return view('papers.index', compact('results'));
    }

    public function show($id, PaperSearchService $searchService)
    {
        $bqDetails = $searchService->findById($id);

        $paper = Paper::find($id);

        $recommendations = [];

        if ($paper) {
            $recommendations = $paper->getRecommendations();
        }

        return view('papers.show', compact('bqDetails', 'paper', 'recommendations', 'id'));
    }
}