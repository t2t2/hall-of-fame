<h2>Delete user?</h2>
{{ Form::open() }}{{ Form::token() }}{{ Form::hidden("delete", true) }}
<p>Are you sure you want to delete {{ HTML::link($video->url, $video->title ?: $video->url) }} and all the votes it has recieved?</p>
{{ Form::submit("Delete", array("class" => "btn-danger")) }} {{ HTML::link_to_action("admin.video@index", "Back", array(), array("class" => "btn")) }}
{{ Form::close() }}