<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Big Data Research Search</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background: #f4f7f6; color: #333; max-width: 800px; margin: 0 auto; padding: 40px 20px; }
        .search-box { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 30px; text-align: center; }
        input[type="text"] { width: 70%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; }
        button { padding: 12px 24px; background: #2563eb; color: white; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; margin-left: 10px; }
        button:hover { background: #1d4ed8; }
        .result-card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 15px; border-left: 5px solid #2563eb; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .result-card a { color: #1e40af; text-decoration: none; font-size: 1.2em; font-weight: bold; }
        .result-card a:hover { text-decoration: underline; }
        .meta { color: #666; font-size: 0.9em; margin-top: 5px; }
    </style>
</head>
<body>

    <div class="search-box">
        <h1>🔍 Academic Graph Search</h1>
        <form action="{{ route('papers.index') }}" method="GET">
            <input type="text" name="q" placeholder="Search millions of papers (e.g., machine learning)..." value="{{ request('q') }}" required>
            <button type="submit">Search</button>
        </form>
    </div>

    @if(isset($results) && count($results) > 0)
        <h2>Top Results (Powered by BigQuery)</h2>
        @foreach($results as $row)
            <div class="result-card">
                <a href="{{ route('papers.show', $row['id']) }}">{{ $row['title'] }}</a>
                <div class="meta"><strong>Year:</strong> {{ $row['year'] }}</div>
                <p>{{ \Illuminate\Support\Str::limit($row['abstract'] ?? 'No abstract available.', 200) }}</p>
            </div>
        @endforeach
    @elseif(request()->has('q'))
        <p>No results found for your query.</p>
    @endif

</body>
</html>