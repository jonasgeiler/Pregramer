<?php

namespace App\Controllers;

use Flight;

class Home {

	/**
	 * @return void
	 */
	public static function index() {
		phpinfo();//Flight::render('home');
	}

}
