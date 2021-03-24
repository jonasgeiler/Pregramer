<?php

use InstagramScraper\Instagram;
use InstagramScraper\Exception\InstagramNotFoundException;
use InstagramScraper\Exception\InstagramAgeRestrictedException;
use InstagramScraper\Exception\InstagramException;
use GuzzleHttp\Client;

class Post {
    public static function show($shortCode) {
    	$instagram = new Instagram(new Client());

    	try {
			$media = $instagram->getMediaByUrl("https://www.instagram.com/p/$shortCode/");
		} catch (InstagramNotFoundException $e) {
			return Flight::notFound('Post not found');
		}
    	
    	Flight::view()->set('media', $media);

    	Flight::view()->set('url', "https://www.instagram.com/p/$shortCode/");
    	Flight::view()->set('embed', Flight::view()->get('url') . 'embed');
    	Flight::view()->set('title', "{$media['owner']['fullName']} on Instagram: “{$media['caption']}”");
    	Flight::view()->set('description', "{$media['likesCount']} Likes, {$media['commentsCount']} Comments - {$media['owner']['fullName']} (@{$media['owner']['username']}) on Instagram: “{$media['caption']}”");

        Flight::render('post');
    }
}