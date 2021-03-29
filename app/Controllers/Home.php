<?php

namespace App\Controllers;

use Flight;

class Home {

	/**
	 * @return void
	 */
	public static function index() {
		Flight::lastModified(filemtime(Flight::view()->getTemplate('home')));
		Flight::render('home');
	}

}
