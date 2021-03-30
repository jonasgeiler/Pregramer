<?php

namespace App\Controllers;

use App\Helpers\Functions as HelperFunctions;

class Privacy {

	/**
	 * @return void
	 * @throws \Exception
	 */
	public static function index (): void {
		HelperFunctions::renderWithLastModified('privacy');
	}

}
