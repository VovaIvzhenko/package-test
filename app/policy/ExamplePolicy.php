<?php
/**
 * Created by PhpStorm.
 * User: ivzhenko.volodymyr
 * Date: 14.05.2019
 * Time: 22:32
 */

namespace app\policy;


use Klein\Request;
use Klein\Response;

/**
 * Class ExamplePolicy
 * @package app\policy
 */
final class ExamplePolicy
{
    /**
     * ExamplePolicy constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        // code
    }

    /**
     * @return bool
     */
    public function checkTrue(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function checkFalse(): bool
    {
        return false;
    }
}