<?php

namespace Pregramer\Controllers;

use Flight;

class Privacy {

	/**
	 * @return void
	 */
	public static function index() {
		Flight::render('privacy');
	}

}
