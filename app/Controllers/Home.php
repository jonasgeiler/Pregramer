<?php

namespace App\Controllers;

use App\Helpers\Functions as HelperFunctions;

class Home {

	/**
	 * @return void
	 * @throws \Exception
	 */
	public static function index (): void {
		HelperFunctions::renderWithLastModified('home');
	}

}
