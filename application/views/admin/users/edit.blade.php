{{ Form::open($target, "POST", array("class" => Form::TYPE_HORIZONTAL)) }}
	{{ Form::token() }}
	{{ Form::field("text", "username", "Username", array(Input::old("username", $user->username)), array("prepend" => "@", "error" => $errors->first("username"))) }}
	{{ Form::field("checkbox", "can_nominate", "Can nominate", array(true, Input::old("can_nominate", $user->can_nominate)), array("error" => $errors->first("can_nominate"))) }}
	{{ Form::field("checkbox", "admin", "Admin", array(true, Input::old("admin", $user->admin)), array("error" => $errors->first("admin"))) }}
	{{ Form::actions(array( Form::submit($user->new ? "Add" : "Save", array("class" => "btn btn-primary")), HTML::link_to_action("admin.user@index", "Back", array(), array("class" => "btn")) )) }}
{{ Form::close() }}