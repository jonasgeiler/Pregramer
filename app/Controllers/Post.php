<?php

namespace Controllers;

use Base;
use Cache;
use GuzzleHttp\Client;
use Helpers\Audit;
use Helpers\Format;
use InstagramScraper\Exception\InstagramNotFoundException;
use InstagramScraper\Instagram;
use View;

class Post {

	private const SESSION_TTL = 4320000; // 50 days

	private const TITLE_MAX_LENGTH = 70;
	private const DESCRIPTION_MAX_LENGTH = 195;

	/**
	 * @param Base  $f3
	 * @param array $params
	 *
	 * @return void
	 * @throws \InstagramScraper\Exception\InstagramAuthException
	 * @throws \InstagramScraper\Exception\InstagramChallengeRecaptchaException
	 * @throws \InstagramScraper\Exception\InstagramChallengeSubmitPhoneNumberException
	 * @throws \InstagramScraper\Exception\InstagramException
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 */
	public static function show (Base $f3, array $params): void {
		$cache = Cache::instance();

		$shortCode = $params['shortcode'];
		$mediaUrl = "https://www.instagram.com/p/$shortCode/";

		if (Audit::isHuman()) {
			$f3->reroute($mediaUrl, false);

			return;
		}

		$instagram = Instagram::withCredentials(
			new Client(),
			$_ENV['INSTAGRAM_USERNAME'],
			$_ENV['INSTAGRAM_PASSWORD'],
			$cache
		);
		$instagram->login();
		$instagram->saveSession(static::SESSION_TTL);

		try {
			$media = $instagram->getMediaByUrl($mediaUrl);
		} catch (InstagramNotFoundException $e) {
			$f3->error(404, 'Post does not exist or account is private');

			return;
		}

		$data = [];

		$data['media'] = $media;
		$data['url'] = $mediaUrl;

		$titleName = $media['owner']['fullName'] ?: "@{$media['owner']['username']}";
		$data['title'] = "Instagram post by $titleName";

		$descriptionName = ( $media['owner']['fullName'] ? "{$media['owner']['fullName']} (@{$media['owner']['username']})" : "@{$media['owner']['username']}" );
		$likesCount = Format::count($media['likesCount']);
		$commentsCount = Format::count($media['commentsCount']);
		$data['description'] = "$likesCount Likes, $commentsCount Comments - $descriptionName on Instagram";

		if ($media['caption']) {
			$titleCaption = Format::truncate($media['caption'], static::TITLE_MAX_LENGTH - strlen($data['title']));
			$data['title'] = "$titleName on Instagram: “{$titleCaption}”";

			$descriptionCaption = Format::truncate($media['caption'], static::DESCRIPTION_MAX_LENGTH - strlen($data['description']));
			$data['description'] .= ": “{$descriptionCaption}”";
		}

		echo View::instance()->render('post.php', 'text/html', $data);
	}

}
