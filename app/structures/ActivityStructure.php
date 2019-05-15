<?php
/**
 * Created by PhpStorm.
 * User: ivzhenko.volodymyr
 * Date: 15.05.2019
 * Time: 11:02
 */

namespace app\structures;


/**
 * Class ActivityStructure
 * @package app\structures
 */
final class ActivityStructure extends Structure
{
    /**
     * @var string
     */
    public $resolution = '';
    /**
     * @var string
     */
    public $userAgent = '';
    /**
     * @var string
     */
    public $referrer = '';
    /**
     * @var array
     */
    public $data = [];
}