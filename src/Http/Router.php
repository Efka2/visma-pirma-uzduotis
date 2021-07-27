<?php

namespace Syllabus\Http;

use Syllabus\Container\Container;

class Router
{
    private const METHOD_POST = 'POST';
    private const METHOD_DELETE = 'DELETE';
    private const METHOD_GET = 'GET';
    private const METHOD_PUT = 'PUT';
    private array $handlers;
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function get(string $path, $handler): void
    {
        $this->addHandler(self::METHOD_GET, $path, $handler);
    }

    public function put(string $path, $handler): void
    {
        $this->addHandler(self::METHOD_PUT, $path, $handler);
    }

    public function post(string $path, $handler): void
    {
        $this->addHandler(self::METHOD_POST, $path, $handler);
    }

    public function delete(string $path, $handler): void
    {
        $this->addHandler(self::METHOD_DELETE, $path, $handler);
    }

    private function addHandler(string $method, string $path, $handler): void
    {
        $this->handlers[$method . $path] = [
            'path' => $path,
            'method' => $method,
            'handler' => $handler
        ];
    }


    public function run()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $parts = explode("/", $requestUri['path']);
        $slug = $parts[3];
//        print_r($parts);
        $requestPath = $requestUri['path'];
//        echo $slug;
        $method = $_SERVER['REQUEST_METHOD'];

        if(!empty($slug)){
            $requestPath = str_replace("$slug", "id", $requestPath);
        }

        $callback = null;
        foreach ($this->handlers as $handler) {
            if ($handler['path'] === $requestPath && $handler['method'] === $method) {
                $callback = $handler['handler'];
            }
        }

        if (is_string($callback)) {
            $parts = explode("::", $callback);
            if (is_array($parts)) {
                $className = array_shift($parts);

                $handler = $this->container->get($className);

                $method = array_shift($parts);
                $callback = [$handler, $method];
            }
        }

        if (!$callback) {
            header("HTTP/1.0 404 Not Found");
        }

        call_user_func_array($callback, [
            array_merge($_GET, $_POST)
        ]);
    }
}
