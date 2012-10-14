<?php
class User extends Eloquent {
	/* Relationships */
	public function videos() {
		return $this->has_many_and_belongs_to("Video");
	}

	/* Sumers */
	public function update_nominated_count() {
		$this->set_attribute("nominations", $this->videos()->count());
		$this->save();
	}
}