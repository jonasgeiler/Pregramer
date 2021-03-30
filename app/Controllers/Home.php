<?php

namespace App\Controllers;

use App\Helpers\Functions as HelperFunctions;

class Home {

	/**
	 * @return void
	 */
	public static function index() {
		HelperFunctions::renderWithLastModified('home');
	}

}
