<?php

class Create_Videos_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("videos", function($table) {
			$table->increments('id');
			$table->string('title', 128)->nullable(); // YouTube title limit is 100 http://productforums.google.com/forum/#!topic/youtube/Hx9lQMg2WTk
			$table->text('url')->nullable();
			$table->string('urlhash', 32); // Fast way to make sure url's are unique http://stackoverflow.com/a/1009531
			$table->string('youtube_id', 16)->nullable();
			$table->integer("nominations");
			$table->timestamps();

			$table->unique('urlhash');
		});
		Schema::create("user_video", function($table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('video_id')->unsigned();
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('cascade');
			$table->foreign('video_id')->references('id')->on('videos')->on_update('cascade')->on_delete('cascade');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("user_video");
		Schema::drop("videos");
	}

}