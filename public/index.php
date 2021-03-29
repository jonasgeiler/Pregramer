<?php

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

require __DIR__ . '/../config/flight.php';
require __DIR__ . '/../config/routes.php';

Flight::path(__DIR__ . '/../app/controllers');

Flight::start();
