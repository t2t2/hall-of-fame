<h2>User - {{$user->username}}</h2>
<div class="pull-right">
	<a href="{{ action("admin.user@edit", array($user->id)) }}" class="btn"><i class="icon-pencil"></i> Edit</a>
	<a href="{{ action("admin.user@delete", array($user->id)) }}" class="btn"><i class="icon-remove"></i> Delete</a>
</div>
@if($user->can_nominate)
	<p>Can nominate: {{ $user->nominations }}/{{ Config::get("application.nominations") }}</p>
@else
	<p>Cannot nominate</p>
@endif
@if($user->admin)
	<p>This user is an admin</p>
@endif
@if($user->can_nominate or count($user->videos))
	<h3>Nominated by this user</h3>
	<ol>
	@forelse($user->videos as $video)
		<li class="video">
			<div class="row-fluid">
				<div class="span2"><a href="{{ action("admin.video@view", array($video->id)) }}" class="thumbnail">{{ HTML::image($video->youtube_id ? "http://img.youtube.com/vi/{$video->youtube_id}/mqdefault.jpg" : "img/unknown_thumb.jpg") }}</a></div>
				<div class="span10">
					<h4>{{ HTML::link_to_action("admin.video@view", $video->title ?: $video->url, array($video->id)) }}</h4>
					<p>{{ HTML::link($video->url, $video->url) }}</p>
				</div>
			</div>
		</li>
	@empty
		<li><p>None</p></li>
	@endforelse
	</ol>
@endif