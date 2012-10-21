@include("home.header")
<div class="page-header"><h2>Nominate videos for 2012!</h2></div>
<h3>Invited guests</h3>
<p>Since you have been invited to submit viral videos for consideration, you can submit <strong>{{ Config::get("application.nominations") }}</strong> videos of your choosing.</p>
<div class="alert alert-block alert-info">
	<h4>Submission rules</h4>
	<ol>
		<li>Video must be viral</li>
		<li>It must have gone viral more than 5 years ago (when in doubt, check <a href="http://knowyourmeme.com/" target="_blank">Know Your Meme</a>)</li>
	</ol>
</div>
@if(Auth::user()->nominations < Config::get("application.nominations"))
	<div class="page-header"><h4>Submit viral videos <small>You have <strong>{{ Config::get("application.nominations") - Auth::user()->nominations }}</strong> nominations left</small></h4></div>
	{{ Form::open(action("nominations@nominate"), "POST", array("class" => "form-horizontal")) }}
		{{ Form::token() }}
		{{ Form::field("text", "video-url", "Video URL", array(Input::old("video-url"), array("class" => "input-xxlarge", "placeholder" => "http://")), array("help" => "We prefer YouTube URL's, but anything can work :)")) }}
		<div class="form-actions">
			{{ Form::submit("Submit", array("class" => "btn btn-primary"))}}
		</div>
	{{ Form::close() }}
@else
	<div class="alert alert-success">
		<p>Thank you for submitting all of your viral videos! We applaud you good sir!</p>
		<p><img src="http://bbliveshow.info/images/8/8d/Jury_clap2.gif" /></p>
	</div>
@endif
<h4>Your submissions</h4>
<ol class="video-list">
	{{ render_each('partials.video', $submissions, 'video') }}
</ol>
