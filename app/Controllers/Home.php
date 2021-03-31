<?php

namespace Controllers;

use View;

class Home {

	/**
	 * @return void
	 */
	public function index (): void {
		echo View::instance()->render('home.php');
	}

}
