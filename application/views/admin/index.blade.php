<h2>Home</h2>
<h3>Latest nominations</h3>
<ol>
	@foreach($nominations->results as $nomination)
		<li>{{ $nomination->created_at }} - {{ HTML::link_to_action("admin.user@view", $nomination->username, array($nomination->user_id)) }} nominated {{ HTML::link_to_action("admin.video@view", $nomination->title ?: $nomination->url, array($nomination->video_id)) }}</li>
	@endforeach
</ol>
{{ $nominations->links() }}