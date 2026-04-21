<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Trending Papers Dashboard</title>

<link rel="stylesheet" href="{{ asset('css/papers.css') }}">

<style>
.grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
gap:20px;
margin-bottom:30px;
}
.card{
background:white;
padding:24px;
border-radius:16px;
box-shadow:0 10px 25px rgba(0,0,0,.05);
}
.metric{
font-size:2rem;
font-weight:700;
color:#2563eb;
margin-top:10px;
}
.section{
margin-top:30px;
}
.paper{
background:white;
padding:18px;
border-radius:14px;
margin-bottom:12px;
box-shadow:0 4px 10px rgba(0,0,0,.04);
}
.paper a{
font-weight:700;
text-decoration:none;
color:#111827;
}
.paper a:hover{
color:#2563eb;
}
.small{
font-size:.9rem;
color:#666;
margin-top:5px;
}
</style>
</head>

<body>

<div class="hero">
<h1>📈 Trending Papers Dashboard</h1>
<p>Live insights from your academic search engine</p>
</div>

<div class="grid">

<div class="card">
<div>Total Papers</div>
<div class="metric">{{ number_format($stats['papers']) }}</div>
</div>

<div class="card">
<div>Searches Today</div>
<div class="metric">{{ number_format($stats['searches']) }}</div>
</div>

<div class="card">
<div>Recommendations Served</div>
<div class="metric">{{ number_format($stats['recs']) }}</div>
</div>

<div class="card">
<div>Trending Topic</div>
<div class="metric">{{ $stats['topic'] }}</div>
</div>

</div>


<div class="section">
<h2>🔥 Most Viewed Papers</h2>

@foreach($trending as $paper)
<div class="paper">
<a href="{{ route('papers.show',$paper['id']) }}">
{{ $paper['title'] }}
</a>
<div class="small">
{{ $paper['year'] }} • {{ $paper['views'] }} views
</div>
</div>
@endforeach
</div>


<div class="section">
<h2>🏆 Most Cited Papers</h2>

@foreach($cited as $paper)
<div class="paper">
<a href="{{ route('papers.show',$paper['id']) }}">
{{ $paper['title'] }}
</a>
<div class="small">
{{ $paper['year'] }} • {{ $paper['citations'] }} citations
</div>
</div>
@endforeach
</div>


<div class="section">
<h2>🧠 Trending Topics</h2>

<div class="grid">
@foreach($topics as $topic)
<div class="card">
<div class="metric">{{ $topic['count'] }}</div>
<div>{{ $topic['name'] }}</div>
</div>
@endforeach
</div>

</div>

</body>
</html>