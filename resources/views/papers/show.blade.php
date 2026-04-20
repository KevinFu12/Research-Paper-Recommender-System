<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $paper->title }}</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background: #f4f7f6; color: #333; max-width: 900px; margin: 0 auto; padding: 40px 20px; line-height: 1.6; }
        a.back { display: inline-block; margin-bottom: 20px; color: #2563eb; text-decoration: none; font-weight: bold; }
        a.back:hover { text-decoration: underline; }
        .main-paper { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 40px; }
        .main-paper h1 { margin-top: 0; color: #111; }
        h2 { border-bottom: 2px solid #ddd; padding-bottom: 10px; color: #444; }
        .rec-card { background: white; padding: 15px 20px; border-radius: 8px; margin-bottom: 15px; border-left: 5px solid #10b981; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .rec-card a { color: #047857; text-decoration: none; font-size: 1.1em; font-weight: bold; }
        .rec-card a:hover { text-decoration: underline; }
        .meta { color: #666; font-size: 0.9em; }
    </style>
</head>
<body>

    <a href="{{ route('papers.index') }}" class="back">&larr; Back to Search</a>

    <div class="main-paper">
        <h1>{{ $paper->title }}</h1>
        <div class="meta"><strong>Published:</strong> {{ $paper->year }}</div>
        <p><em>(Abstract data is stored in BigQuery, but this PostgreSQL record confirms the paper exists in your vector database).</em></p>
    </div>

    <h2>AI Recommended Papers</h2>
    <p>Based on content similarity (pgvector cosine distance):</p>

    <div class="recommendations">
        @forelse($recommendations as $rec)
            <div class="rec-card">
                <a href="{{ route('papers.show', $rec->id) }}">{{ $rec->title }}</a>
                <div class="meta"><strong>Published:</strong> {{ $rec->year }}</div>
            </div>
        @empty
            <p>No similar papers found in the database.</p>
        @endforelse
    </div>

</body>
</html>