<?php

    require_once ('src/Syllabus/IO/Reader.php');
    require_once ('src/Syllabus/Service/Syllabus.php');
    require_once ('src/Syllabus/Core/Application.php');

    use Syllabus\Core\Application;

    $application = new Application();
    $application->run();
