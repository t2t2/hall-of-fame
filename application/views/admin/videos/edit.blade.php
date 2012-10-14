{{ Form::open($target, "POST", array("class" => Form::TYPE_HORIZONTAL)) }}
	{{ Form::token() }}
	{{ Form::field("text", "title", "Title", array(Input::old("title", $video->title)), array("error" => $errors->first("title"))) }}
	{{ Form::field("text", "url", "URL", array(Input::old("url", $video->url)), array("error" => $errors->first("url"))) }}
	{{ Form::field("text", "youtube_id", "YouTube ID", array(Input::old("youtube_id", $video->youtube_id)), array("error" => $errors->first("youtube_id"))) }}
	{{ Form::actions(array( Form::submit($video->new ? "Add" : "Save", array("class" => "btn btn-primary")), HTML::link_to_action("admin.video@index", "Back", array(), array("class" => "btn")) )) }}
{{ Form::close() }}