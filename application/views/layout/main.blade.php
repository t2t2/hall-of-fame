<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>{{ isset($title) ? $title ." | " : ""}} Viral Video Hall Of Fame!</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width">

		{{ Asset::styles().Asset::container('header')->scripts() }}
	</head>
	<body>
		<!--[if lt IE 7]>
			<p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
		<![endif]-->

		<div class="container">
			<header class="row">
				<div class="span6">
					<a href="{{ URL::home() }}" class="headerlink" title="Back to home!">Viral Video Hall of Fame</a>
				</div>
				<div class="span6 userbox">
					@if(Auth::check())
						Hello {{Auth::user()->username}}!
						@if(Auth::user()->admin)
							| {{ HTML::link("admin", "Admin") }}
						@endif
						{{ Form::open(action("user@logout"), "POST", array("id" => "logout-form")) }}
							{{ Form::token() }}
							{{ Form::submit("Log out", array("id" => "logout-btn", "class" => "btn btn-link")) }}
						{{ Form::close() }}
					@else
						<a href="{{ action("user@login") }}">{{ HTML::image('img/sign-in-with-twitter-l.png') }}</a>
					@endif
				</div>
			</header>
			@if ($messages = Messagely::get())
				<div class="info-messages">
					@foreach ($messages as $group => $msgs)
						<div class="alert alert-<?php echo $group; ?>">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							@foreach ($msgs as $msg)
								<p>{{ $msg }}</p>
							@endforeach
						</div>
					@endforeach
				</div>
			@endif

			@section('content')
				{{ $content }}
			@yield_section

			<hr>

			<footer>
				<p>
					&copy; <a href="http://nsfwshow.com/" target="_blank">NSFWshow</a> 1999 - 2012 | <a href="https://github.com/t2t2/hall-of-fame" target="_blank">&lt;3 open source!</a>
				</p>
			</footer>

		</div> <!-- /container -->

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="{{ asset("js/vendor/jquery-1.8.2.min.js") }}"><\/script>')</script>
		{{ Asset::scripts() }}

		<script>
			var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
			(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
			g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
			s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>
	</body>
</html>
