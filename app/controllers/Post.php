<?php

use EspressoDev\InstagramBasicDisplay\InstagramBasicDisplay;

class Post {
    public static function show($shortCode) {
        $instagram = new InstagramBasicDisplay(self::getAccessToken());
        echo self::getCodeFromId(17876670409844782); // CFkGWjIpyac
        //var_dump($instagram->getMedia(self::getIdFromCode($shortCode)));
        return;

    	Flight::view()->set('media', $media);

    	Flight::view()->set('url', "https://www.instagram.com/p/$shortCode/");
    	Flight::view()->set('embed', Flight::view()->get('url') . 'embed');
    	Flight::view()->set('title', "{$media['owner']['fullName']} on Instagram: “{$media['caption']}”");
    	Flight::view()->set('description', "{$media['likesCount']} Likes, {$media['commentsCount']} Comments - {$media['owner']['fullName']} (@{$media['owner']['username']}) on Instagram: “{$media['caption']}”");

        Flight::render('post');
    }


    private static function getAccessToken() {
        return file_get_contents(__DIR__ . '/../../access_token.txt');
    }

    private static function getCodeFromId($id) {
        $parts = explode('_', $id);
        $id = $parts[0];
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';
        $code = '';
        while ($id > 0) {
            $remainder = $id % 64;
            $id = ($id - $remainder) / 64;
            $code = $alphabet[$remainder] . $code;
        };
        return $code;
    }

    private static function getIdFromCode($code) {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';
        $id = 0;
        for ($i = 0; $i < strlen($code); $i++) {
            $c = $code[$i];
            $id = $id * 64 + strpos($alphabet, $c);
        }
        return $id;
    }
}