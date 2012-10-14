<h2>Home</h2>
<h3>Latest nominations</h3>
<ol>
	@foreach($nominations->results as $nomination)
		<li>{{ $nomination->created_at }} - {{ $nomination->username }} nominated {{ $nomination->title ?: $nomination->url }}</li>
	@endforeach
</ol>
{{ $nominations->links() }}