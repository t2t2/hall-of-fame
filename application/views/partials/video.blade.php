<li class="video">
	<div class="row-fluid">
		<div class="span3"><a href="{{ URL::to($video->url) }}" class="thumbnail">{{ HTML::image($video->youtube_id ? "http://img.youtube.com/vi/{$video->youtube_id}/mqdefault.jpg" : "img/unknown_thumb.jpg") }}</a></div>
		<div class="span9">
			<h4>{{ HTML::link($video->url, $video->title ?: $video->url) }}</h4>
			<p>Nominated by: {{ implode(", ", array_map(function($user) {return $user->username;}, $video->users)) }}</p>
		</div>
	</div>
</li>