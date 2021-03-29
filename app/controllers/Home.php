<?php

namespace Pregramer\Controllers;

use Flight;

class Home {

	/**
	 * @return void
	 */
	public static function index() {
		Flight::render('home');
	}

}
