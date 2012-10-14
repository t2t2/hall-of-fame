<?php

class Create_Users_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("users", function($table) {
			$table->increments('id');
			$table->string("username", 16);
			$table->integer("can_nominate")->default(1);
			$table->integer("nominations");
			$table->boolean("admin");
			$table->timestamps();

			$table->unique('username');
		});
		User::create(array("username" => "RealHorseboy", "can_nominate" => 0, "admin" => true));
		User::create(array("username" => "t2t2", "can_nominate" => 0, "admin" => true));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("users");
	}

}