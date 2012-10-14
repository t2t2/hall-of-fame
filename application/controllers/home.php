<?php

class Home_Controller extends Base_Controller {

	public $layout = "layout.main";
	public $restful = true;

	public function get_index() {
		if(Auth::check()) {
			$submissions = Auth::user()->videos();
			$submissions->model->_with("users");
			$submissions = $submissions->results();
			if(count($submissions) != Auth::user()->nominations) {
				Auth::user()->update_nominated_count();
			}

			$this->layout->nest("content", "home.submit", array("submissions" => $submissions));
		} else {
			$this->layout->nest("content", "home.index");
		}
		
	}

}