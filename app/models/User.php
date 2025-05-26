<?php

use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\UserValidator;
use Zizaco\Confide\ConfideUserInterface;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements ConfideUserInterface {

	use ConfideUser;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';


}
