<?php

use Pregramer\Controllers\Error;
use Pregramer\Controllers\Home;
use Pregramer\Controllers\Post;
use Pregramer\Controllers\Privacy;

Flight::route('GET /', [Home::class, 'index']);
Flight::route('GET /privacy', [Privacy::class, 'index']);
Flight::route('GET /@shortcode:[0-9A-Za-z_-]+', [Post::class, 'show']);

Flight::map('notFound', [Error::class, 'notFound']);
Flight::map('error', [Error::class, 'error']);
Flight::map('halt', [Error::class, 'halt']);
