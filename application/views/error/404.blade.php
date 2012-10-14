@layout("layout.main")
<?php
$title = "404";
$content = "";
?>
@section("content")
	<h1>404</h1>
	<p>There's no video here :( {{ HTML::link(URL::home(), "Try going back to home?") }} </p>
@endsection