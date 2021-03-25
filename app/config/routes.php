<?php

require __DIR__ . '/error.php';

Flight::route('GET /', 'Home::index');
Flight::route('GET /privacy', 'Privacy::index');

Flight::route('GET /@shortcode', 'Post::show');

Flight::route('GET /cron/refresh-access-token', 'Cron::refreshAccessToken');