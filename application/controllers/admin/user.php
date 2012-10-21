<?php

class Admin_User_Controller extends Base_Controller {

	public $layout = "layout.admin";
	public $restful = true;

	public function __construct() {
		parent::__construct();

		$this->filter("before", "admin");
		$this->filter("before", "csrf")->on("post")->only(array("new", "edit", "delete"));
	}

	public function get_index() {
		$users = User::paginate(50);
		
		$this->layout->title = "Users | Admin";
		$this->layout->nest("content", "admin.users.list", array("users" => $users));
	}
	public function get_new() {
		$this->layout->nest("content", "admin.users.edit", array(
			"target" => action("admin.user@new"), "user" => new User()
		));
	}
	public function post_new() {
		// Checkbox fixing man!
		Input::merge(array("can_nominate" => Input::get("can_nominate") ? 1 : 0, "admin" => Input::get("admin") ? 1 : 0));

		$validation_rules = array(
			"username" => "required|max:16|unique:users,username",
			"can_nominate" => "required|in:0,1",
			"admin" => "required|in:0,1",
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			$user = new User();
			$user->username     = Input::get("username");
			$user->can_nominate = Input::get("can_nominate");
			$user->admin        = Input::get("admin");
			if($user->save()) {
				Messagely::flash("success", "User made!");
				return Redirect::to_action("admin.user@index");
			} else {
				Log::error("Error when saving new user ".print_r($user->to_array(), true));
				Messagely::flash("error", "Failed to save user!");
				return Redirect::to_action("admin.user@new")->with_input();
			}
		} else {
			Messagely::flash("error", "Please fix the problems and try again");
			return Redirect::to_action("admin.user@new")->with_input()->with_errors($validation);
		}
	}
	public function get_view($id) {
		$user = User::find($id);
		if(!$user) {
			Messagely::flash("error", "User not found");
			return Redirect::to_action("admin.user@index");
		}

		$this->layout->nest("content", "admin.users.view", array(
			"user" => $user
		));
	}
	public function get_edit($id) {
		$user = User::find($id);
		if(!$user) {
			Messagely::flash("error", "User not found");
			return Redirect::to_action("admin.user@index");
		}

		$this->layout->nest("content", "admin.users.edit", array(
			"target" => action("admin.user@edit", array($id)), "user" => $user
		));
	}
	public function post_edit($id) {
		$user = User::find($id);
		if(!$user) {
			Messagely::flash("error", "User not found");
			return Redirect::to_action("admin.user@index");
		}
		// Checkbox fixing man!
		Input::merge(array("can_nominate" => Input::get("can_nominate") ? 1 : 0, "admin" => Input::get("admin") ? 1 : 0));

		$validation_rules = array(
			"username" => "required|max:16|unique:users,username,{$user->id}",
			"can_nominate" => "required|in:0,1",
			"admin" => "required|in:0,1",
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			$user->username     = Input::get("username");
			$user->can_nominate = Input::get("can_nominate");
			$user->admin        = Input::get("admin");
			if($user->save()) {
				Messagely::flash("success", "User updated!");
				return Redirect::to_action("admin.user@index");
			} else {
				Log::error("Error when saving user ".print_r($user->to_array(), true));
				Messagely::flash("error", "Failed to save user!");
				return Redirect::to_action("admin.user@edit", array($id))->with_input();
			}
		} else {
			Messagely::flash("error", "Please fix the problems and try again");
			return Redirect::to_action("admin.user@edit", array($id))->with_input()->with_errors($validation);
		}
	}
	public function get_delete($id) {
		$user = User::find($id);
		if(!$user) {
			Messagely::flash("error", "User not found");
			return Redirect::to_action("admin.user@index");
		}

		$this->layout->nest("content", "admin.users.delete", array(
			"user" => $user
		));
	}
	public function post_delete($id) {
		$user = User::find($id);
		if(!$user) {
			Messagely::flash("error", "User not found");
			return Redirect::to_action("admin.user@index");
		}

		if(Input::get("delete")) {
			if($user->delete()) {
				Messagely::flash("success", "User deleted!");
			} else {
				Log::error("Error when deleting user ".print_r($user->to_array(), true));
				Messagely::flash("error", "Failed to delete user!");
			}
		}
		return Redirect::to_action("admin.user@index");
	}
}