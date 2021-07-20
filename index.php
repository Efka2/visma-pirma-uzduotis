<?php

require_once('vendor/autoload.php');

use Syllabus\Core\Application;
use Syllabus\Core\Logger;

header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");


if (!$_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    $application = new Application(new Logger());
    $application->run();
} else {

    include('src/Http/Routes.php');

}
