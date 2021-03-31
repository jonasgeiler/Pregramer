<?php

namespace Helpers;

class Format {

	/**
	 * Truncate a string
	 *
	 * @param string $string
	 * @param int    $length
	 *
	 * @return string
	 */
	public static function truncate (string $string, $length = 100): string {
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
	public static function count (float $num, $precision = 1): string {
		$absNum = abs($num);

		if ($absNum < 10000) {
			return number_format((string) round($num, $precision));
		}

		$groups = [ 'k', 'm', 'b' ];

		foreach ($groups as $i => $group) {
			$div = 1000 ** ($i + 1);

			if ($absNum < $div * 1000) {
				return round($num / $div, $precision) . $group;
			}
		}

		return '999q+';
	}

}
