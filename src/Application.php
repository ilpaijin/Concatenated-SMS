<?php

namespace Ilpaijin;

use Exception;

/**
 * Class Application
 * @package Ilpaijin
 */
class Application
{
    /**
     * @var \Ilpaijin\DIContainer
     */
    public $container = '';
    /**
     *
     */
    public $routes = [];

    /**
     * Application constructor.
     * @param DIContainer $container
     */
    public function __construct(DIContainer $container)
    {
        $this->container = $container;
    }

    /**
     *
     */
    public function run()
    {
        header("Content-Type: application/json; charset=utf-8;");

        $requestUri = explode("/", ltrim($_SERVER['REQUEST_URI'], "/"));

        $route_match = $this->routes[$requestUri[0]];

        $controller = "Ilpaijin\\Controller\\".ucfirst($route_match);

        if (!$route_match || !class_exists($controller)) {
            return $this->sendError('Route Not Found');
        }

        $controller = new $controller($this->container);

        $method = strtolower($_SERVER['REQUEST_METHOD']);

        $request = "";
        $body = ['data' => ''];

        switch ($method) {
            case 'get':
                $request = isset($requestUri[1]) && is_numeric($requestUri[1]) ? $requestUri[1] : "";
                $action = $request ? "getOne" : "getAll";
                $status = "200 OK";
                break;
            case 'post':
                $request = file_get_contents('php://input');
                $action = "post";
                $status = "201 Created";
                break;
            default:
                break;
        }

        if (!method_exists($controller, $action)) {
            return $this->sendError('Server Error', '500 Server Error');
        }

        ob_start();

        try {
            $result = $controller->$action($request);

            switch(gettype($result)) {
                case 'array':
                    if (isset($result['error'])) {
                        throw new Exception($result['error']);
                    }
                    $body = isset($result['data']) && !empty($result['data']) ? $result['data'] : $body;
                    break;
                case 'object':
                    $result = json_decode(json_encode($result), true);
                    if (isset($result['error'])) {
                        throw new Exception($result['error']);
                    }
                    $body = isset($result['data']) && !empty($result['data']) ? $result['data'] : $result;
                    break;
                case 'string':
                case 'integer':
                    $body = $result;
                    break;
            }
            $status = isset($result['status']) ? $result['status'] : $status;

            header("HTTP/1.1 {$status}");
            echo json_encode(['data' => $body]);

        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        ob_end_flush();
    }

    /**
     *
     */
    private function sendError($error, $status = '400 Bad Request')
    {
        header("HTTP/1.1 " . $status);
        echo json_encode(["error" => $error]);
        ob_end_flush();
    }
}