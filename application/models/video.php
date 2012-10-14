<?php
class Video extends Eloquent {
	/* Relationships */
	public function users() {
		return $this->has_many_and_belongs_to("User");
	}

	/* Setters */
	public function set_url($url) {
		$this->set_attribute("url", $url);
		$this->set_attribute("urlhash", md5($url));
	}

	/* Sumers */
	public function update_nominated_count() {
		$this->set_attribute("nominations", $this->users()->count());
		$this->save();
	}
}