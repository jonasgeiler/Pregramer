<?php

Flight::set('flight.views.path', __DIR__ . '/../views');
Flight::set('cache.path', __DIR__ . '/../../.cache');

Flight::set('env', $_ENV['ENV']);

if (Flight::get('env') === 'production') {
	ini_set('error_log', __DIR__ . '/../../error.log');
	ini_set('display_errors', 0);

	Flight::set('log_errors', true);
} else {
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
}
