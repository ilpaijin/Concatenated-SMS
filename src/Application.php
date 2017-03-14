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
     * @var array
     */
    public $services = [];
    /**
     *
     */
    public $routes = [];

    /**
     *
     */
    public function run()
    {
        $requestUri = explode("/", ltrim($_SERVER['REQUEST_URI'], "/"));

        $route_match = $this->routes[$requestUri[0]];

        $controller = "Ilpaijin\\Controller\\".ucfirst($route_match);

        if (!$route_match || !class_exists($controller)) {
            $this->sendError();
            return;
        }

        $controller = new $controller();

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

        ob_start();

        try {
            header("Content-Type: application/json; charset=utf-8;");

            $result = $controller->$action($request);

            switch(gettype($result)) {
                case 'array':
                    $body = isset($result['data']) && !empty($result['data']) ? $result['data'] : $body;
                    break;
                case 'string':
                    $body = $result;
                    break;
            }
            $status = isset($result['status']) ? $result['status'] : $status;

            header("HTTP/1.1 {$status}");
            echo json_encode(['data' => $body]);

        } catch (Exception $e) {
            header("HTTP/1.1 {$e->getCode()} {$e->getMessage()}");
            echo json_encode(["error" => $e->getMessage()]);
        }

        ob_end_flush();
    }

    /**
     *
     */
    private function sendError()
    {
        header("HTTP/1.1 400 Bad Request");
        ob_end_flush();
    }
}