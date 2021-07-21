<?php

require_once __DIR__ . ('/vendor/autoload.php');

use Syllabus\Container\Container;
use Syllabus\Core\Application;

header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");


if (!$_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    $container = new Container();
    $application = $container->get(Application::class);
    $application->run();
} else {
    include('src/Syllabus/Http/Routes.php');
}
