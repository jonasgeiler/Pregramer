<?php

use EspressoDev\InstagramBasicDisplay\InstagramBasicDisplay;

class Cron {
	public static function refreshAccessToken() {
		$path = __DIR__ . '/../../access_token.txt';

		$accessToken = file_get_contents($path);
		$instagram = new InstagramBasicDisplay($accessToken);

		$newAccessToken = $instagram->refreshToken($accessToken, true);
		file_put_contents($path, $newAccessToken);
	}
}