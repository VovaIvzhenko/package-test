<?php
/**
 * Created by PhpStorm.
 * User: ivzhenko.volodymyr
 * Date: 14.05.2019
 * Time: 18:18
 */

namespace app;


use app\controllers\ExampleController;
use app\controllers\LogController;
use app\exceptions\SecureException;
use app\middleware\MiddlewareFactory;
use Klein\Klein;
use Klein\Request;
use Klein\Response;

/**
 * Class Router
 * @package app
 */
class Router
{
    /**
     * @var Klein
     */
    private $klein;

    /**
     * @var array
     */
    private $routes = [
        ExampleController::class => [
            // without base path /api/v1
            ['GET', '/example/to', 'methodCalled', 'json'],
            ['GET', '/example/path', 'methodTest', 'json']
        ],
        LogController::class => [
            ['POST', '/log/activity', 'sendActivity', 'json']
        ]
    ];

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->klein = new Klein();
        $this->init();
        $this->onHttpError();
        $this->klein->dispatch();
    }

    public function init()
    {
        $controller = $this->defineController();

        if (!class_exists($controller)) {
            $this->triggerError("[Router error] Controller {$controller} not exist");
        }

        $this->klein->with('/api/v1', function (Klein $klein) use ($controller) {
            $routes = $this->routes[$controller];
            if (empty($routes)) {
                $this->triggerError("[Router error] Routes {$routes} not exist");
            }
            $this->registerRoutes($routes, $controller, $klein);
        });
    }

    /**
     * @param array $routes
     * @param string $controller
     * @param Klein $klein
     */
    public function registerRoutes(array $routes, string $controller, Klein $klein)
    {
        foreach ($routes as $route) {
            [$httpMethod, $path, $method, $responseType] = $route;

            $klein->respond($httpMethod, $path, function (Request $request, Response $response)
            use ($path, $method, $responseType, $controller) {
                $result = $error = null;

                try {
                    $middleware = MiddlewareFactory::factory($controller);

                    if (!$middleware->allowMethodCall($request, $response, $method)) {
                        throw new SecureException('Access is denied');
                    }

                    if (method_exists($controller, $method) && is_callable($controller, $method)) {
                        $result = (new $controller)->{$method}($request, $response);
                    } else {
                        throw new \Exception("[Router error] The requested method {$method} does not exist");
                    }
                } catch (SecureException $e) {
                    $error = $e->getMessage();
                } catch (\Exception $e) {
                    $error = $e->getMessage();
                }

                $response->{$responseType}([
                    'error' => $error,
                    'result' => $result
                ]);
            });
        }
    }

    /**
     * @return string
     */
    public function defineController(): string
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $uriPath = explode('/', $requestUri);
        $prefix = !empty($uriPath[3]) ? $uriPath[3] : '_';

        if (strpos($prefix, '-')) {
            $prefixExp = explode('-', $prefix);
            $prefix = '';
            foreach ($prefixExp as $prefixPart) {
                $prefix .= ucfirst($prefixPart);
            }
        }

        return 'app\controllers\\' . ucfirst($prefix) . 'Controller';
    }

    /**
     * @param string $errorMessage
     */
    public function triggerError(string $errorMessage)
    {
        trigger_error($errorMessage, E_USER_WARNING);
        exit(1);
    }

    public function onHttpError()
    {
        $this->klein->onHttpError(function ($code, $router) {
            switch ($code) {
                case 404:
                    $router->response()->body(
                        'Code 404.'
                    );
                    break;
                case 405:
                    http_response_code(405);
                    $router->response()->body(
                        'You can\'t do that!'
                    );
                    break;
                default:
                    $router->response()->body(
                        'Oh no, a bad error happened that caused a ' . $code
                    );
            }
        });
    }
}