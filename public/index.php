<?php

use Slim\Factory\AppFactory;
//use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

// https://packagist.org/packages/vlucas/phpdotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

$app = AppFactory::create();

require __DIR__ . '/../src/config/db.php';
require __DIR__ . '/../src/routes/names.php';

// If you are adding the pre-packaged ErrorMiddleware set `displayErrorDetails` to `false`
$app->addErrorMiddleware(false, true, true);
$app->run();
