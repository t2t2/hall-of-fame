<h2>Merge <em>{{e($video->title ?: $video->url)}}</em> to...</h2>
{{ Form::open() }}
	{{ Form::token() }}
	<div class="row-fluid">
		<div class="span6">
			<div class="well well-small">
				<h3 class="small-title">Old and busted</h3>
				{{ HTML::link($video->url, $video->title ?: $video->url ) }}
			</div>
		</div>
		<div class="span6">
			<div class="well well-small">
				<h3 class="small-title">New Hotness</h3>
				{{ Form::select("new-video", $other_videos, null, array("class" => "span12")) }}
			</div>
		</div>
	</div>
	{{ Form::actions(array(Form::submit("Merge", array("class" => "btn-primary")), HTML::link_to_action("admin.video@index", "Back", array(), array("class" => "btn")))) }}
{{ Form::close() }}