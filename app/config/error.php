<?php

function getErrorPage ($title, $code, $message, $error = null) {
	ob_start();

	Flight::view()->set('title', $title);
	Flight::view()->set('activeSite', '');
	Flight::view()->set('activePage', '');
	Flight::view()->set('code', $code);
	Flight::view()->set('message', $message);

	if ($error && Flight::get('env') !== 'production') {
		Flight::view()->set('error', $error);
	}

	Flight::render('_error');

	return ob_get_clean();
}

Flight::map('notFound', function ($message = 'Not Found') {
	$errorPage = getErrorPage('Not Found', 404, $message);

	try {
		Flight::response()
		      ->clear()
		      ->status(404)
		      ->write($errorPage)
		      ->send();
		exit();
	} catch (Throwable $t) { // PHP 7.0+
		exit($errorPage);
	}
});

Flight::map('error', function ($e) {
	$errorPage = getErrorPage('Internal Server Error', 500, 'Internal Server Error', [
		'message' => $e->getMessage() . ' in ' .($e->getFile() ?: '[N/A]') . ' on line ' . ($e->getLine() ?: '[N/A]'),
		'code'    => $e->getCode(),
		'trace'   => $e->getTraceAsString(),
	]);

	try {
		Flight::response()
		     ->clear()
		     ->status(500)
		     ->write($errorPage)
		     ->send();
		exit();
	} catch (Throwable $t) { // PHP 7.0+
		exit($errorPage);
	}
});

Flight::map('halt', function ($code = 200, $message = '') {
	$title = \flight\net\Response::$codes[$code] ?? $message;
	$errorPage = getErrorPage($title, $code, $message);

	try {
		Flight::response()
		      ->clear()
		      ->status($code)
		      ->write($errorPage)
		      ->send();
		exit();
	} catch (Throwable $t) { // PHP 7.0+
		exit($errorPage);
	}
});