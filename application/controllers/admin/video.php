<?php

class Admin_Video_Controller extends Base_Controller {

	public $layout = "layout.admin";
	public $restful = true;

	public function __construct() {
		parent::__construct();

		$this->filter("before", "admin");
		$this->filter("before", "csrf")->on("post")->only(array("edit", "merge", "delete"));
	}

	public function get_index() {
		$videos = Video::paginate(50);
		
		$this->layout->title = "Video | Admin";
		$this->layout->nest("content", "admin.videos.list", array("videos" => $videos));
	}

	public function get_view($id) {
		$video = Video::find($id);
		if(!$video) {
			Messagely::flash("error", "Video not found");
			return Redirect::to_action("admin.video@index");
		}

		$this->layout->title = e($video->title)?:"Untitled video"." | Video | Admin";
		$this->layout->nest("content", "admin.videos.view", array(
			"video" => $video
		));
	}

	public function get_edit($id) {
		$video = Video::find($id);
		if(!$video) {
			Messagely::flash("error", "Video not found");
			return Redirect::to_action("admin.video@index");
		}

		$this->layout->nest("content", "admin.videos.edit", array(
			"target" => action("admin.video@edit", array($id)), "video" => $video
		));
	}
	public function post_edit($id) {
		$video = Video::find($id);
		if(!$video) {
			Messagely::flash("error", "Video not found");
			return Redirect::to_action("admin.video@index");
		}

		Validator::register('urlhash', function($attribute, $value, $parameters) {
			// We allow the table column to be specified just in case the column does
			// not have the same name as the attribute. It must be within the second
			// parameter position, right after the database table name.
			if (isset($parameters[1])) {
				$attribute = $parameters[1];
			}

			$query = DB::table($parameters[0])->where($attribute, '=', md5($value));

			// We also allow an ID to be specified that will not be included in the
			// uniqueness check. This makes updating columns easier since it is
			// fine for the given ID to exist in the table.
			if (isset($parameters[2])) {
				$id = (isset($parameters[3])) ? $parameters[3] : 'id';

				$query->where($id, '<>', $parameters[2]);
			}

			return $query->count() == 0;
		});
		$validation_rules = array(
			"title" => "max:128",
			"url"   => "required|url|urlhash:videos,urlhash,{$video->id}",
			"youtube_id" => "between:11,16",
		);
		$validation = Validator::make(Input::all(), $validation_rules, array("urlhash" => "The :attribute must be unique"));
		if($validation->passes()) {
			$video->title      = Input::get("title");
			$video->url        = Input::get("url");
			$video->youtube_id = Input::get("youtube_id");
			if($video->save()) {
				Messagely::flash("success", "Video updated!");
				return Redirect::to_action("admin.video@index");
			} else {
				Log::error("Error when saving video ".print_r($video->to_array(), true));
				Messagely::flash("error", "Failed to save video!");
				return Redirect::to_action("admin.video@edit", array($id))->with_input();
			}
		} else {
			Messagely::flash("error", "Please fix the problems and try again");
			return Redirect::to_action("admin.video@edit", array($id))->with_input()->with_errors($validation);
		}
	}

	public function get_merge($id) {
		$video = Video::find($id);
		if(!$video) {
			Messagely::flash("error", "Video not found");
			return Redirect::to_action("admin.video@index");
		}
		$other_videos = array();
		foreach (Video::where("id", "!=", $video->id)->get() as $video) {
			$other_videos[$video->id] = "#{$video->id} - {$video->title}";
		}

		$this->layout->title = "Merge | Video | Admin";
		$this->layout->nest("content", "admin.videos.merge", array(
			"video" => $video, "other_videos" => $other_videos
		));
	}
	public function post_merge($id) {
		$video = Video::with("users")->find($id);
		if(!$video) {
			Messagely::flash("error", "Video not found");
			return Redirect::to_action("admin.video@index");
		}
		if(!Input::get("new-video")) {
			Messagely::flash("error", "New video not found");
			return Redirect::to_action("admin.video@index");
		}
		$new_video = Video::with("users")->find(Input::get("new-video"));
		if(!Input::get("new-video")) {
			Messagely::flash("error", "New video not found");
			return Redirect::to_action("admin.video@index");
		}

		/* Move votes over */
		$voters = $video->users;
		$new_video_voters = array_map(function($user) {
			return $user->id;
		}, $new_video->users);
		$video->users()->delete();
		foreach ($voters as $user) {
			if(in_array($user->id, $new_video_voters)) {
				// Dupe vote
				$user->update_nominated_count();
			} else {
				// Move over
				$new_video->users()->attach($user);
			}
		}
		/* Insert duplicate rule */
		$merge_rule = new Video_Merge();
		$merge_rule->url = $new_video->url;
		$video->merges()->insert($merge_rule);
		/* Delete old entry */
		$video->delete();
		$new_video->update_nominated_count();

		Messagely::flash("success", "Videos merged!");
		return Redirect::to_action("admin.video@view", array($new_video->id));
	}

	public function get_delete($id) {
		$video = Video::find($id);
		if(!$video) {
			Messagely::flash("error", "Video not found");
			return Redirect::to_action("admin.video@index");
		}

		$this->layout->nest("content", "admin.videos.delete", array(
			"video" => $video
		));
	}
	public function post_delete($id) {
		$video = Video::find($id);
		if(!$video) {
			Messagely::flash("error", "Video not found");
			return Redirect::to_action("admin.video@index");
		}

		if(Input::get("delete")) {
			if($video->delete()) {
				Messagely::flash("success", "User deleted!");
			} else {
				Log::error("Error when deleting video ".print_r($video->to_array(), true));
				Messagely::flash("error", "Failed to delete the video!");
			}
		}
		return Redirect::to_action("admin.video@index");
	}


}