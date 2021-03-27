<?php

require __DIR__ . '/error.php';

Flight::route('GET /', 'Home::index');
Flight::route('GET /privacy', 'Privacy::index');
Flight::route('GET /@shortcode:[0-9A-Za-z_-]+', 'Post::show');