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
}