<?php

require_once __DIR__ . ('/vendor/autoload.php');

use Syllabus\Container\Container;
use Syllabus\Controller\WordController;
use Syllabus\Core\Application;
use Syllabus\Handler\PatternWordHandler;
use Syllabus\Handler\WordHandler;
use Syllabus\Http\Router;
use Syllabus\IO\FileReaderInterface;
use Syllabus\IO\Reader;
use Syllabus\Service\Syllabus;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");

$container = new Container();

if (!$_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    $application = $container->get(Application::class);
    $application->run();
} else {
    $loader = new FilesystemLoader('views');
    $twig = new Environment($loader);

    $router = $container->get(Router::class);
    $reader = $container->get(Reader::class);
    $syllabus = $container->get(Syllabus::class);
    $wordHandler = $container->get(WordHandler::class);
    $patternWordHandler = $container->get(PatternWordHandler::class);
    $wordController = new WordController($syllabus, $patternWordHandler, $wordHandler, $twig);

    $router->get('/', function() use ($twig) {
        $template = $twig->load('home.twig.html');

        echo $template->render();
    });

    $router->get('/word', function() use ($wordController) {
        $wordController->index();
    });

    $router->get('/word/show/id', function () use ($wordController){
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', $uri);
        $id = $uri[3];

        $wordController->show($id);
    });

    $router->get('/word/edit/id', function() use($wordController) {

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', $uri);
        $id = $uri[3];

        $wordController->edit($id);
    });

    $router->post('/word/edit/id', function() use ($wordController, $reader){
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', $uri);
        $replaceWord = trim($_POST['word_string']);
        $id = $uri[3];
        $patterns = $reader->readFromFileToCollection(FileReaderInterface::DEFAULT_PATTERN_LINK);

        $wordController->update($id, $replaceWord, $patterns);
    });

    $router->get('/word/create', function () use ($wordController){
        $wordController->create();
    });

    $router->post('/word/create', function() use ($wordController, $reader){
        $wordString = trim($_POST['word_string']);
        $patterns = $reader->readFromFileToCollection(FileReaderInterface::DEFAULT_PATTERN_LINK);

        $wordController->store($wordString, $patterns);
    });

    $router->delete('/word/delete/id', function () use ($wordHandler, $wordController) {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', $uri);
        $id = $uri[3];

        $wordController->delete($id);
    });

    $router->run();
}
