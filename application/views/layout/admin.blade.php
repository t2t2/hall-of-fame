@layout("layout.main")

@section("content")
	<div class="row">
		<div class="span3">
			<div class="well nav-list-well">
				<ul class="nav nav-list">
					<li class="nav-header">Admin Panel</li>
					<li{{ !URI::segment(2) ? " class=\"active\"" : ""}}><a href="{{ URL::to_action("admin@index") }}"><i class="icon-home"></i> Home</a></li>
					<li{{ URI::segment(2) == "user" ? " class=\"active\"" : ""}}><a href="{{ URL::to_action("admin.user@index") }}"><i class="icon-user"></i> Users</a></li>
					<li{{ URI::segment(2) == "video" ? " class=\"active\"" : ""}}><a href="{{ URL::to_action("admin.video@index") }}"><i class="icon-facetime-video"></i> Videos</a></li>
				</ul>
			</div>
		</div>
		<div class="span9">
			@parent
		</div>
	</div>
@endsection