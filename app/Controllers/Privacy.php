<?php

namespace App\Controllers;

use Flight;

class Privacy {

	/**
	 * @return void
	 */
	public static function index() {
		Flight::lastModified(filemtime(Flight::view()->getTemplate('privacy')));
		Flight::render('privacy');
	}

}
