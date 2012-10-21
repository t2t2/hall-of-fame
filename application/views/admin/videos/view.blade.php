<h2>Video - {{e($video->title)}}</h2>
<div class="pull-right">
	<a href="{{ action("admin.video@edit", array($video->id)) }}" class="btn"><i class="icon-pencil"></i> Edit</a>
	<a href="{{ action("admin.video@merge", array($video->id)) }}" class="btn"><i class="icon-filter"></i> Merge</a>
	<a href="{{ action("admin.video@delete", array($video->id)) }}" class="btn"><i class="icon-remove"></i> Delete</a>
</div>
<p>{{ HTML::link($video->url, $video->url) }}</p>
<p><a href="{{ URL::to($video->url) }}" class="thumbnail">{{ HTML::image($video->youtube_id ? "http://img.youtube.com/vi/{$video->youtube_id}/mqdefault.jpg" : "img/unknown_thumb.jpg") }}</a></p>
<h3>Nominated by users ({{ $video->nominations }}):</h3>
<ol>
@forelse($video->users as $user)
	<li>{{ HTML::link_to_action("admin.user@view", $user->username, array($user->id)) }}</li>
@empty
	<li><p>None</p></li>
@endforelse
</ol>
<h3>Alternative URL's</h3>
<ul>
@forelse($video->merges as $merger)
	<li>{{ HTML::link($merger->url, $merger->url) }}</li>
@empty
	<li>None</li>
@endforelse
</ul>