<?php

namespace Pregramer\Controllers;

use Flight;
use GuzzleHttp\Client;
use InstagramScraper\Exception\InstagramNotFoundException;
use InstagramScraper\Instagram;
use Phpfastcache\Config\ConfigurationOption;
use Phpfastcache\Helper\Psr16Adapter;
use Pregramer\Helpers\Constants;

class Post {

	/**
	 * @param string $shortCode
	 * @return void
	 */
	public static function show($shortCode) {
		$cache = new Psr16Adapter('Files', new ConfigurationOption([
			'path' => Flight::get('cache.path'),
			'defaultTtl' => Constants::EXPIRE_CREDENTIALS,
		]));

		$mediaUrl = "https://www.instagram.com/p/$shortCode/";

		if (static::isHuman($cache)) {
			Flight::redirect($mediaUrl, 301);

			return;
		}

		$cacheKey = md5($shortCode);
		$media = $cache->get($cacheKey);

		if (!$media) {
			$instagram = Instagram::withCredentials(
				new Client(),
				$_ENV['INSTAGRAM_USERNAME'],
				$_ENV['INSTAGRAM_PASSWORD'],
				$cache
			);
			$instagram->login();

			try {
				$media = $instagram->getMediaByUrl($mediaUrl);
			} catch (InstagramNotFoundException $e) {
				Flight::notFound('Post does not exist or account is private');

				return;
			}

			$cache->set($cacheKey, $media, Constants::EXPIRE_MEDIA);
		}

		Flight::view()->set('media', $media);
		Flight::view()->set('url', $mediaUrl);

		$titleName = $media['owner']['fullName'] ?: "@{$media['owner']['username']}";
		$descriptionName = ($media['owner']['fullName'] ? "{$media['owner']['fullName']} (@{$media['owner']['username']})" : "@{$media['owner']['username']}");

		$title = $media['caption'] ? "$titleName on Instagram: “{$media['caption']}”" : "Instagram post by $titleName";
		$description = "{$media['likesCount']} Likes, {$media['commentsCount']} Comments - $descriptionName on Instagram";

		if ($media['caption']) {
			$description .= ": “{$media['caption']}”";
		}

		Flight::view()->set('title', $title);
		Flight::view()->set('description', $description);

		Flight::render('post');
	}

	/**
	 * @param \Phpfastcache\Helper\Psr16Adapter $cache
	 * @return bool
	 */
	private static function isHuman($cache) {
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		$cacheKey = md5($userAgent);
		$isHuman = $cache->get($cacheKey);

		if ($isHuman !== null) {
			return $isHuman;
		}

		$browserInfo = get_browser($userAgent, true);
		$isHuman = in_array($browserInfo['browser'], Constants::BROWSERS);

		$cache->set($cacheKey, $isHuman, Constants::EXPIRE_HUMAN_CHECK);

		return $isHuman;
	}

}
