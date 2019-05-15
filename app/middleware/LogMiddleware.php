<?php
/**
 * Created by PhpStorm.
 * User: ivzhe
 * Date: 15.05.2019
 * Time: 10:49
 */

namespace app\middleware;


use app\policy\ExamplePolicy;

class LogMiddleware extends Middleware
{
    protected $allowedMethods = [
        'sendActivity' => [
            ExamplePolicy::class => 'checkTrue'
        ]
    ];
}