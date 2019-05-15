<?php
/**
 * Created by PhpStorm.
 * User: ivzhenko.volodymyr
 * Date: 14.05.2019
 * Time: 21:50
 */

namespace app\middleware;


use app\controllers\ExampleController;
use app\controllers\LogController;

/**
 * Class MiddlewareFactory
 * @package app\middleware
 */
final class MiddlewareFactory
{
    /**
     * @var array
     */
    private static $middlewarePool = [
        ExampleController::class => ExampleMiddleware::class,
        LogController::class => LogMiddleware::class
    ];

    /**
     * @param string $controller
     * @return mixed
     */
    public static function factory(string $controller)
    {
        if (!empty(self::$middlewarePool[$controller])) {
            return new self::$middlewarePool[$controller]();
        }

        throw new \InvalidArgumentException('[Middleware error] Unknown controller given');
    }
}