<?php

    require_once('autoload.php');

    use Syllabus\Core\Application;
    use Syllabus\Core\Logger;

    $application = new Application(new Logger());
    $application->run();
