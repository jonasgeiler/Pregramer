<?php

namespace App\Helpers;

use Flight;

class Functions {

	/**
	 * Renders a template and sends Last-Modified header.
	 *
	 * @param string $file Template file
	 * @param array|null $data Template data
	 * @throws \Exception If template not found
	 * @return void
	 */
	public static function renderWithLastModified($file, $data = null) {
		Flight::lastModified(filemtime(Flight::view()->getTemplate($file)));
		Flight::render($file);
	}

	/**
	 * Get the last modification timestamp of a cache item
	 *
	 * @param string $cacheKey Key of the cache item
	 * @return int The last modification timestamp
	 */
	public static function getCacheLastModified($cacheKey) {
		$cacheItem = Flight::cache()
			->getInternalCacheInstance()
			->getItem($cacheKey);

		return $cacheItem
			->getModificationDate()
			->getTimestamp();
	}

	/**
	 * Checks User Agent and returns true if user is human
	 *
	 * @return bool If the user is human
	 */
	public static function isHuman() {
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		$cacheKey = md5($userAgent);
		$isHuman = Flight::cache()->get($cacheKey);

		if ($isHuman !== null) {
			return $isHuman;
		}

		$browserInfo = get_browser($userAgent, true);
		$isHuman = in_array($browserInfo['browser'], Constants::BROWSERS);

		Flight::cache()->set($cacheKey, $isHuman, Constants::EXPIRE_HUMAN_CHECK);

		return $isHuman;
	}

	/**
	 * Truncate a string
	 *
	 * @param string $string
	 * @param int $length
	 * @param string $etc The string to append when truncating
	 * @return string
	 */
	public static function truncateStr($string, $length = 100) {
		if (strlen($string) > $length) {
			$string = $string . ' ';
			$string = substr($string, 0, $length);
			$string = substr($string, 0, strrpos($string, ' '));
			$string = $string . '…';
		}

		return $string;
	}

}
