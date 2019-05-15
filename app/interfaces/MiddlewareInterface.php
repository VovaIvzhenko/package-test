<?php
/**
 * Created by PhpStorm.
 * User: ivzhenko.volodymyr
 * Date: 14.05.2019
 * Time: 22:19
 */

namespace app\interfaces;



use Klein\Request;
use Klein\Response;

/**
 * Interface MiddlewareInterface
 * @package app\interfaces
 */
interface MiddlewareInterface
{
    /**
     * @param Request $request
     * @param Response $response
     * @param string $method
     * @return bool
     */
    public function allowMethodCall(Request $request, Response $response, string $method): bool;
}