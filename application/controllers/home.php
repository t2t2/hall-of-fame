<?php

class Home_Controller extends Base_Controller {

	public $layout = "layout.main";
	public $restful = true;

	public function get_index() {
		if(Auth::check() && Auth::user()->can_nominate) {
			$submissions = Auth::user()->videos();
			$submissions->model->_with("users");
			$submissions = $submissions->results();
			if(count($submissions) != Auth::user()->nominations) {
				Auth::user()->update_nominated_count();
			}

			$this->layout->nest("content", "home.submit", array("submissions" => $submissions));
		} else {
			if(Auth::check()) {
				Messagely::add("warning", "This message should only appear for admins who haven't been on the show. If you think it's wrong, please contact us.");
			}
			$this->layout->nest("content", "home.index");
		}
		
	}

}