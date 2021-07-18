<?php

    require_once('autoload.php');
    require_once ('src/Syllabus/Core/Router.php');
    use Syllabus\Core\Application;
    use Syllabus\Core\Logger;
    use Syllabus\Core\Router;

    $router = new Router();
    $router->get('/', function (){
        echo "It's home page\n";
    });
    $router->get('/about', function (){
        echo "It's about page";
    });
    $router->run();
    
    if(empty ($_SERVER)){
        $application = new Application(new Logger());
        $application->run();
    } else {
    }
