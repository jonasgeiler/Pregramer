<?php

namespace App\Controllers;

use Flight;
use flight\net\Response;

class Error {

	/**
	 * @param string $message
	 *
	 * @return void
	 */
	public static function notFound (string $message = 'Not Found'): void {
		$errorPage = static::getErrorPage('Not Found', 404, $message);

		try {
			Flight::response()
			      ->clear()
			      ->status(404)
			      ->write($errorPage)
			      ->send();
			exit();
		} catch (\Throwable $t) {
			exit($errorPage);
		}
	}

	/**
	 * @param \Exception $e
	 *
	 * @return void
	 */
	public static function error (\Exception $e): void {
		$errorPage = static::getErrorPage('Internal Server Error', 500, 'Internal Server Error', [
			'message' => $e->getMessage() . ' in ' . ( $e->getFile() ?: '[N/A]' ) . ' on line ' . ( $e->getLine() ?: '[N/A]' ),
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
		} catch (\Throwable $t) {
			exit($errorPage);
		}
	}

	/**
	 * @param int    $code
	 * @param string $message
	 *
	 * @return void
	 */
	public static function halt (int $code = 200, string $message = ''): void {
		$title = Response::$codes[$code] ?? $message;
		$errorPage = static::getErrorPage($title, $code, $message);

		try {
			Flight::response()
			      ->clear()
			      ->status($code)
			      ->write($errorPage)
			      ->send();
			exit();
		} catch (\Throwable $t) {
			exit($errorPage);
		}
	}

	/**
	 * @param string          $title
	 * @param int             $code
	 * @param string          $message
	 * @param array|null $error
	 *
	 * @return string
	 */
	private static function getErrorPage (string $title, int $code, string $message, $error = null): string {
		ob_start();

		$data = [];

		$data['title'] = $title;
		$data['code'] = $code;
		$data['message'] = $message;

		if ($error && Flight::get('env') !== 'production') {
			$data['error'] = $error;
		}

		Flight::render('_error', $data);

		return ob_get_clean();
	}

}
