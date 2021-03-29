<?php

namespace App\Controllers;

use Flight;
use flight\net\Response;

class Error {

	/**
	 * @param string $message
	 * @return void
	 */
	public static function notFound($message = 'Not Found') {
		$errorPage = static::getErrorPage('Not Found', 404, $message);

		try {
			Flight::response()
				->clear()
				->status(404)
				->write($errorPage)
				->send();
			exit();
		} catch (Throwable $t) {
			exit($errorPage);
		}
	}

	/**
	 * @param \Exception $e
	 * @return void
	 */
	public static function error($e) {
		$errorPage = static::getErrorPage('Internal Server Error', 500, 'Internal Server Error', [
			'message' => $e->getMessage() . ' in ' . ($e->getFile() ?: '[N/A]') . ' on line ' . ($e->getLine() ?: '[N/A]'),
			'code' => $e->getCode(),
			'trace' => $e->getTraceAsString(),
		]);

		try {
			Flight::response()
				->clear()
				->status(500)
				->write($errorPage)
				->send();
			exit();
		} catch (Throwable $t) {
			exit($errorPage);
		}
	}

	/**
	 * @param int $code
	 * @param string $message
	 * @return void
	 */
	public static function halt($code = 200, $message = '') {
		$title = Response::$codes[$code] ?? $message;
		$errorPage = static::getErrorPage($title, $code, $message);

		try {
			Flight::response()
				->clear()
				->status($code)
				->write($errorPage)
				->send();
			exit();
		} catch (Throwable $t) {
			exit($errorPage);
		}
	}

	/**
	 * @param string $title
	 * @param int $code
	 * @param string $message
	 * @param \Exception|null $error
	 * @return string
	 */
	private static function getErrorPage($title, $code, $message, $error = null) {
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

}
