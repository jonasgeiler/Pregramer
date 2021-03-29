<?php

Flight::set('flight.views.path', __DIR__ . '/../app/Views');
Flight::set('cache.path', __DIR__ . '/../storage/cache');

Flight::set('env', $_ENV['ENV']);

if (Flight::get('env') === 'production') {
	ini_set('error_log', __DIR__ . '/../storage/logs/' . date('Y-m-d') . '.txt');

	error_reporting(0);
	ini_set('display_errors', 0);

	Flight::set('flight.log_errors', true);
} else {
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
}
