<?php

class User_Controller extends Base_Controller {

	public $restful = true;

	public function __construct() {
		parent::__construct();

		$this->filter("before", "csrf")->on("post")->only("logout");
	}

	public function get_login() {
		if(Auth::check()) {
			return Redirect::home();
		} else {
			try {
				$url = Auth::getAuthenticateUrl(action("user@login_callback"));
				return Redirect::to($url);
			} catch(Exception $e) {
				Messagely::flash("error", "Whoops, twitter isn't groovy right now. Try again later?");
				Log::error("Failed to get oauth token - ".print_r($e, true));
				return Redirect::home();
			}
		}
	}

	public function get_login_callback() {
		if(Auth::check()) {
			return Redirect::home();
		} else {
			try {
				$success = Auth::attempt(array("oauth_token" => Input::get('oauth_token'), "oauth_verifier" => Input::get("oauth_verifier")));
			} catch(Exception $e) {
				Messagely::flash("error", "Whoops, twitter isn't groovy right now. Try again later?");
				Log::error("Failed to get oauth token - ".print_r($e, true));
				return Redirect::home();
			}
			if($success) {
				Messagely::flash("success", "Hello ".Auth::user()->username."!");
				return Redirect::home();
			} else {
				Messagely::flash("error", "You're not on the list. If you believe this is an error, please contact us!");
				return Redirect::home();
			}
		}
	}

	public function post_logout() {
		Auth::logout();
		Messagely::flash("success", "Goodbye! :)");
		return Redirect::home();
	}
}