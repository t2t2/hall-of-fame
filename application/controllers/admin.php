<?php

class Admin_Controller extends Base_Controller {

	public $layout = "layout.admin";
	public $restful = true;

	public function __construct() {
		parent::__construct();

		$this->filter("before", "admin");
	}

	public function get_index() {
		$nominations = DB::table("user_video")->order_by("user_video.created_at", "desc")->join("videos", "videos.id", "=", "user_video.video_id")->join("users", "users.id", "=", "user_video.user_id")->paginate(25, array("user_video.id", "user_video.*", "videos.title", "videos.url", "users.username"));

		$this->layout->title = "Admin";
		$this->layout->nest("content", "admin.index", array("nominations" => $nominations));
	}

}