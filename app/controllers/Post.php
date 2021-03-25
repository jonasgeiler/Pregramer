<?php

use EspressoDev\InstagramBasicDisplay\InstagramBasicDisplay;

class Post {
    public static function show($shortCode_) {
        //$instagram = new InstagramBasicDisplay(self::getAccessToken());
        $shortCode = 'CFkGWjIpyac';
        $media = [
            'id' => '17876670409844782',
            'shortCode' => $shortCode,
            'caption' => '☕ 🌧️',
            'likesCount' => 13,
            'commentsCount' => 2,
            'type' => 'image',
            'altText' => 'Photo by ❮ SKAYO ❯ in Vienna, Austria. May be an image of animal and coffee cup.',
            'imageHighResolutionUrl' => 'https://scontent-vie1-1.cdninstagram.com/v/t51.2885-15/e35/s1080x1080/120089625_640331753336795_6539817173380713190_n.jpg?tp=1&_nc_ht=scontent-vie1-1.cdninstagram.com&_nc_cat=111&_nc_ohc=Ty7FZUwrWt8AX_kZJ9g&ccb=7-4&oh=df1d0efc6d30fd1d7972b272eb2bc025&oe=6086D11D&_nc_sid=83d603',
            'owner' => [
                'fullName' => '❮ SKAYO ❯',
                'username' => 'skayonas'
            ]
        ];

    	Flight::view()->set('media', $media);

    	Flight::view()->set('url', "https://www.instagram.com/p/$shortCode/");
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