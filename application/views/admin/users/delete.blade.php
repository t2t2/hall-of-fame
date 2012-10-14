<h2>Delete user?</h2>
{{ Form::open() }}{{ Form::token() }}{{ Form::hidden("delete", true) }}
<p>Are you sure you want to delete {{ $user->username }} and all the votes (s)he has done?</p>
{{ Form::submit("Delete", array("class" => "btn-danger")) }} {{ HTML::link_to_action("admin.user@index", "Back", array(), array("class" => "btn")) }}
{{ Form::close() }}