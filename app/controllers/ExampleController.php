<?php
/**
 * Created by PhpStorm.
 * User: ivzhenko.volodymyr
 * Date: 14.05.2019
 * Time: 18:36
 */

namespace app\controllers;


/**
 * Class ExampleController
 * @package app\controllers
 */
final class ExampleController extends Controller
{
    /**
     * @return string
     */
    public function methodCalled()
    {
        return __METHOD__;
    }

    /**
     * @return string
     */
    public function methodTest()
    {
        return __METHOD__;
    }
}