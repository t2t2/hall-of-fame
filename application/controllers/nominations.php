<?php
class Nominations_Controller extends Base_Controller {
	public $restful = true;

	public function __construct() {
		parent::__construct();

		$this->filter("before", "auth");
		$this->filter("before", "csrf")->on("post")->only("nominate");
	}

	public function post_nominate() {
		if(!Auth::user()->can_nominate) {
			Messagely::flash("error", "You cannot nominate videos!");
			return Redirect::back()->with_input();
		}
		if(Auth::user()->nominations >= Config::get("application.nominations")) {
			Messagely::flash("error", "You have already nominated all the videos you can!");
			return Redirect::back()->with_input();
		}
		$video_url = Input::get("video-url");
		if(!URL::valid($video_url)) {
			Messagely::flash("error", "Invalid url!");
			return Redirect::back()->with_input();
		}
		// Check if a youtube URL
		$urlinfo = parse_url($video_url);
		if(in_array(strtolower($urlinfo["host"]), array("www.youtube.com", "youtube.com", "youtu.be"))) {
			if(strtolower($urlinfo["host"]) == "youtu.be") {
				$youtube_id = ltrim($urlinfo["path"], "/");
			} else {
				parse_str($urlinfo["query"], $urlquery);
				$youtube_id = $urlquery["v"];
			}
			// Check if already in database
			if($video = Video::where_youtube_id($youtube_id)->first()) {
				// Check if user has already nominated it
				if($video->users()->where_user_id(Auth::user()->id)->first()) {
					Messagely::flash("error", "You have already nominated this video!");
					return Redirect::back()->with_input();
				}
			} else {
				// Get video metadata
				//file_get_contents("http://gdata.youtube.com/feeds/api/videos/{$youtube_id}");
				$mc = EpiCurl::getInstance();
				$ch = curl_init("http://gdata.youtube.com/feeds/api/videos/{$youtube_id}");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$youtube = $mc->addEasyCurl($ch);
				if($youtube->code != 200) {
					Messagely::flash("error", "According to YouTube this isn't an valid video ID. Try re-entering the URL?");
					return Redirect::back()->with_input();
				}
				$sxml = simplexml_load_string($youtube->data);
				if(!$sxml->title) {
					Log::error("Youtube fell over and died {$youtube_id} - ".print_r($sxml));
					Messagely::flash("error", "YouTube fell over and died. While we clean up the body, mind trying again later?");
					return Redirect::back()->with_input();
				}
				$video_title = $sxml->title;

				// Add video to the database
				$video = Video::create(array("title" => $video_title, "url" => "http://www.youtube.com/watch?v={$youtube_id}", "youtube_id" => $youtube_id));
			}
		} else {
			// Check if already in database
			$urlhash = md5($video_url);
			if($video = Video::where_urlhash($urlhash)->first()) {
				// Check if user has already nominated it
				if($video->users()->where_user_id(Auth::user()->id)->first()) {
					Messagely::flash("error", "You have already nominated this video!");
					return Redirect::back()->with_input();
				}
			} else {
				// Add video
				$video = Video::create(array("url" => $video_url));
			}
		}
		if($video && Auth::user()->videos()->attach($video)) {
			Auth::user()->update_nominated_count();
			$video->update_nominated_count();
			Messagely::flash("success", "Video submitted!");
			return Redirect::back();
		} else {
			Messagely::flash("error", "Error when saving your nomination :(");
			return Redirect::back()->with_input();
		}
	}
}