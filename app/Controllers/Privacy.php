<?php

namespace App\Controllers;

use App\Helpers\Functions as HelperFunctions;

class Privacy {

	/**
	 * @return void
	 */
	public static function index() {
		HelperFunctions::renderWithLastModified('privacy');
	}

}
