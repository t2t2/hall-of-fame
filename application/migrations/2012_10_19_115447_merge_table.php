<?php

class Merge_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("video_merges", function($table) {
			$table->increments('id');
			$table->text('url')->nullable();
			$table->string('urlhash', 32)->unique(); // Fast way to make sure url's are unique http://stackoverflow.com/a/1009531
			$table->integer('video_id')->unsigned();
			$table->timestamps();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("video_merges");
	}

}