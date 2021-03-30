<?php

namespace App\Controllers;

use App\Helpers\Constants;
use App\Helpers\Functions as HelperFunctions;
use Flight;
use GuzzleHttp\Client;
use InstagramScraper\Exception\InstagramNotFoundException;
use InstagramScraper\Instagram;
use Phpfastcache\Config\ConfigurationOption;
use Phpfastcache\Helper\Psr16Adapter;

class Post {

	/**
	 * @param string $shortCode
	 *
	 * @return void
	 */
	public static function show(string $shortCode): void {
		Flight::register('cache', Psr16Adapter::class, [
			'Files',
			new ConfigurationOption([
				'itemDetailedDate' => true,
				'path'             => Flight::get('cache.path'),
				'defaultTtl'       => Constants::EXPIRE_CREDENTIALS,
			]),
		]);

		$mediaUrl = "https://www.instagram.com/p/$shortCode/";

		if (HelperFunctions::isHuman()) {
			Flight::redirect($mediaUrl, 301);

			return;
		}

		$cacheKey = md5($shortCode);
		$media = Flight::cache()->get($cacheKey);

		if (!$media) {
			$instagram = Instagram::withCredentials(
				new Client(),
				$_ENV['INSTAGRAM_USERNAME'],
				$_ENV['INSTAGRAM_PASSWORD'],
				Flight::cache()
			);
			$instagram->login();

			try {
				$media = $instagram->getMediaByUrl($mediaUrl);
			} catch (InstagramNotFoundException $e) {
				Flight::notFound('Post does not exist or account is private');

				return;
			}

			Flight::cache()->set($cacheKey, $media, Constants::EXPIRE_MEDIA);
		}

		$data = [];

		$data['media'] = $media;
		$data['url'] = $mediaUrl;

		$titleName = $media['owner']['fullName'] ?: "@{$media['owner']['username']}";
		$data['title'] = "Instagram post by $titleName";

		$descriptionName = ($media['owner']['fullName'] ? "{$media['owner']['fullName']} (@{$media['owner']['username']})" : "@{$media['owner']['username']}");
		$likesCount = HelperFunctions::formatCount($media['likesCount']);
		$commentsCount = HelperFunctions::formatCount($media['commentsCount']);
		$data['description'] = "$likesCount Likes, $commentsCount Comments - $descriptionName on Instagram";

		if ($media['caption']) {
			$titleCaption = HelperFunctions::truncateStr($media['caption'], Constants::TITLE_MAX_LENGTH - strlen($data['title']));
			$data['title'] = "$titleName on Instagram: “{$titleCaption}”";

			$descriptionCaption = HelperFunctions::truncateStr($media['caption'], Constants::DESCRIPTION_MAX_LENGTH - strlen($data['description']));
			$data['description'] .= ": “{$descriptionCaption}”";
		}

		Flight::lastModified(HelperFunctions::getCacheLastModified($cacheKey));
		Flight::render('post', $data);
	}

}
