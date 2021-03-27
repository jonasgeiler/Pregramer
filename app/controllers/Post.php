<?php

use InstagramScraper\Instagram;
use InstagramScraper\Exception\InstagramNotFoundException;
use Phpfastcache\Helper\Psr16Adapter;
use Phpfastcache\Config\ConfigurationOption;
use GuzzleHttp\Client;

class Post {
	public static function show($shortCode) {
		$cache = new Psr16Adapter('Files', new ConfigurationOption([
			'path' => Flight::get('cache.path'),
			'defaultTtl' => 4320000 // expire in 50 days by default
		]));
		$cacheKey = md5($shortCode);

		$media = $cache->get($cacheKey);
		$mediaUrl = "https://www.instagram.com/p/$shortCode/";

		if (!$media) {
			if (self::isHuman($cache)) {
				Flight::redirect($mediaUrl, 301);
				return;
			}

			$instagram = Instagram::withCredentials(new Client(), $_ENV['INSTAGRAM_USERNAME'], $_ENV['INSTAGRAM_PASSWORD'], $cache);
			$instagram->login();

			try {
				$media = $instagram->getMediaByUrl($mediaUrl);
			} catch (InstagramNotFoundException $e) {
				Flight::notFound('Post does not exist or account is private');
				return;
			}

			$cache->set($cacheKey, $media, 604800); // expire in a week
		}

		Flight::view()->set('media', $media);

		Flight::view()->set('url', $mediaUrl);
		Flight::view()->set('title', "{$media['owner']['fullName']} on Instagram: “{$media['caption']}”");
		Flight::view()->set('description', "{$media['likesCount']} Likes, {$media['commentsCount']} Comments - {$media['owner']['fullName']} (@{$media['owner']['username']}) on Instagram: “{$media['caption']}”");

		Flight::render('post');
	}

	private static function isHuman($cache) {
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		$cacheKey = md5($userAgent);

		$isHuman = $cache->get($cacheKey);
		if ($isHuman !== null) return $isHuman;

		$browsers = require __DIR__ . '/../helpers/browsers.php';
		$browserInfo = get_browser($userAgent, true);

		$isHuman = in_array($browserInfo['browser'], $browsers);

		$cache->set($cacheKey, $isHuman, 315360000); // expire in 10 years
		return $isHuman;
	}
}