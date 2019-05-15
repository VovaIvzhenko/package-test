<?php
/**
 * Created by PhpStorm.
 * User: ivzhenko.volodymyr
 * Date: 14.05.2019
 * Time: 18:39
 */

namespace app\middleware;


use app\policy\ExamplePolicy;

/**
 * Class ExampleMiddleware
 * @package app\middleware
 */
final class ExampleMiddleware extends Middleware
{
    /**
     * @var array
     */
    protected $allowedMethods = [
        'methodTest' => [
            ExamplePolicy::class => 'checkTrue'
        ],
        'methodCalled' => []
    ];
}