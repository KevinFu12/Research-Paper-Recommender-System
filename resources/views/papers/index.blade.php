<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Academic Papers Search</title>

<link rel="stylesheet" href="{{ asset('css/papers.css') }}">
</head>

<body>

<div class="hero">
    <h1>Academic Papers Search</h1>
    <p>Search millions of research papers powered by Big Data + AI</p>

    <form action="{{ route('papers.index') }}" method="GET" class="search-form">

        <input
            type="text"
            name="q"
            placeholder="Try: machine learning, NLP, blockchain..."
            value="{{ request('q') }}"
            required
        >

        <button type="submit">Search</button>

        <div class="filters">
            <select name="year">
                <option value="">All Years</option>
                <option value="2025" {{ request('year')=='2025' ? 'selected' : '' }}>2025+</option>
                <option value="2020" {{ request('year')=='2020' ? 'selected' : '' }}>2020+</option>
                <option value="2015" {{ request('year')=='2015' ? 'selected' : '' }}>2015+</option>
            </select>

            <select name="sort">
                <option value="relevance" {{ request('sort')=='relevance' ? 'selected' : '' }}>Sort: Relevance</option>
                <option value="latest" {{ request('sort')=='latest' ? 'selected' : '' }}>Latest</option>
                <option value="oldest" {{ request('sort')=='oldest' ? 'selected' : '' }}>Oldest</option>
            </select>

            <select name="limit">
                <option value="10" {{ request('limit')=='10' ? 'selected' : '' }}>10 Results</option>
                <option value="20" {{ request('limit')=='20' ? 'selected' : '' }}>20 Results</option>
                <option value="50" {{ request('limit')=='50' ? 'selected' : '' }}>50 Results</option>
            </select>
        </div>

    </form>
</div>


@if(isset($results) && count($results) > 0)

<div class="results-header">
    <h2>Top Results</h2>

    <div class="results-count">
        Showing {{ $results->firstItem() }} - {{ $results->lastItem() }}
        of {{ $results->total() }} papers
    </div>
</div>


@foreach($results as $row)

<div class="result-card">

    <a class="result-title" href="{{ route('papers.show', $row['id']) }}">
        {{ $row['title'] }}
    </a>

    <div class="meta">

        <span class="badge">
            {{ $row['year'] ?? 'N/A' }}
        </span>

        @if(isset($row['authors']))
            <span class="badge">
                {{ \Illuminate\Support\Str::limit($row['authors'], 35) }}
            </span>
        @endif

        @if(isset($row['citations']))
            <span class="badge">
                {{ $row['citations'] }} Citations
            </span>
        @endif

    </div>

    <p class="abstract">
        {{ \Illuminate\Support\Str::limit($row['abstract'] ?? 'No abstract available.', 250) }}
    </p>

    <div class="actions">

        <a href="{{ route('papers.show', $row['id']) }}" class="btn-small primary">
            View Details
        </a>

        @if(isset($row['pdf_url']))
        <a href="{{ $row['pdf_url'] }}" target="_blank" class="btn-small">
            PDF
        </a>
        @endif

        <a href="#" class="btn-small">
            Save
        </a>

    </div>

</div>

@endforeach


<div class="pagination-wrapper">
    {{ $results->appends(request()->query())->links() }}
</div>

@endif



@if(request()->has('q') && (!isset($results) || count($results) == 0))

<div class="empty">
    <h2>No results found</h2>
    <p>Try AI, cloud computing, NLP, big data...</p>
</div>

@endif

</body>
</html>