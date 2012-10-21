<?php
class Video_Merge extends Eloquent {
	/* Relationships */
	public function video() {
		return $this->belongs_to("Video");
	}

	/* Setters */
	public function set_url($url) {
		$this->set_attribute("url", $url);
		$this->set_attribute("urlhash", md5($url));
	}
}