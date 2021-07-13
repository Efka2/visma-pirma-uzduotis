<?php

    require_once('autoload.php');

    use Syllabus\Core\Application;
    use Syllabus\Core\Logger;
use Syllabus\Service\Syllabus;

    $application = new Application(new Logger());
    $application->run();
