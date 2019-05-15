<?php
/**
 * Created by PhpStorm.
 * User: ivzhenko.volodymyr
 * Date: 14.05.2019
 * Time: 18:39
 */

namespace app\middleware;


use app\interfaces\MiddlewareInterface;
use Klein\Request;
use Klein\Response;

/**
 * Class Middleware
 * @package app\middleware
 */
abstract class Middleware implements MiddlewareInterface
{
    /**
     * @var array
     */
    protected $allowedMethods = [];

    /**
     * @param Request $request
     * @param Response $response
     * @param string $method
     * @return bool
     * @throws \Exception
     */
    public function allowMethodCall(Request $request, Response $response, string $method): bool
    {
        $allow = false;

        if (!isset($this->allowedMethods[$method])) {
            throw new \Exception("[Middleware error] Middleware rules not set for method {$method}");
        }

        foreach ($this->allowedMethods[$method] as $policyObject => $policyMethod) {
            if (!method_exists($policyObject, $policyMethod) || !is_callable($policyObject, $policyMethod)) {
                throw new \Exception("[Middleware error] Impossible to call policy method {$policyMethod}");
            }

            $allow = (new $policyObject($request, $response))->{$policyMethod}();
        }

        return $allow;
    }
}