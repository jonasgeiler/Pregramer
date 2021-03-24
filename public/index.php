<?php
require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../app/config/flight.php';
require __DIR__ . '/../app/config/routes.php';

Flight::path(__DIR__ . '/../app/controllers');

Flight::start();