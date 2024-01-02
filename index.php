<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';
require_once 'helpers.php';

use App\Command\SendData;
use App\Command\CreateSerialConnection;
use Symfony\Component\Console\Application;

$app = new Application(
    name: 'PHP Serial Connector',
    version: '1.0.0'
);

$app->add(new CreateSerialConnection());
$app->add(new SendData());

$app->run();
