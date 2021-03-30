<?php

namespace App\Helpers;

use Flight;
use JetBrains\PhpStorm\Pure;

class Functions {

	/**
	 * Renders a template and sends Last-Modified header.
	 *
	 * @param string     $file Template file
	 * @param array|null $data Template data
	 *
	 * @return void
	 * @throws \Exception If template not found
	 */
	public static function renderWithLastModified (string $file, $data = null): void {
		Flight::lastModified(filemtime(Flight::view()->getTemplate($file)));
		Flight::render($file);
	}

	/**
	 * Get the last modification timestamp of a cache item
	 *
	 * @param string $cacheKey Key of the cache item
	 *
	 * @return int The last modification timestamp
	 */
	public static function getCacheLastModified (string $cacheKey): int {
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
	public static function isHuman () {
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		$cacheKey = md5($userAgent);
		$isHuman = Flight::cache()->get($cacheKey);

		if ($isHuman !== null) {
			return $isHuman;
		}

		$browserInfo = get_browser($userAgent, true);
		$isHuman = in_array($browserInfo['browser'], Constants::BROWSERS, true);

		Flight::cache()->set($cacheKey, $isHuman, Constants::EXPIRE_HUMAN_CHECK);

		return $isHuman;
	}

	/**
	 * Truncate a string
	 *
	 * @param string $string
	 * @param int    $length
	 *
	 * @return string
	 */
	#[Pure] public static function truncateStr (string $string, $length = 100) {
		if (strlen($string) > $length) {
			$string .= ' ';
			$string = substr($string, 0, $length);
			$string = substr($string, 0, strrpos($string, ' '));
			$string .= '…';
		}

		return $string;
	}

	/**
	 * Formats a number to the short format (ex. 1000 -> 1k)
	 *
	 * @param float $num
	 * @param int   $precision
	 *
	 * @return string
	 */
	#[Pure] public static function formatCount (float $num, $precision = 1): string {
		$absNum = abs($num);

		if ($absNum < 10000) {
			return number_format((string) round($num, $precision));
		}

		$groups = [ 'k', 'm', 'b' ];

		foreach ($groups as $i => $group) {
			$div = 1000 ** ( $i + 1 );

			if ($absNum < $div * 1000) {
				return round($num / $div, $precision) . $group;
			}
		}

		return '999q+';
	}

}
