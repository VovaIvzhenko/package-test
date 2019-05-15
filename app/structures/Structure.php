<?php
/**
 * Created by PhpStorm.
 * User: ivzhe
 * Date: 15.05.2019
 * Time: 11:04
 */

namespace app\structures;


use app\interfaces\StructureInterfaces;

/**
 * Class Structure
 * @package app\structures
 */
abstract class Structure implements StructureInterfaces
{
    /**
     * Structure constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->setProperties((object)$data);
    }

    /**
     * @param $data
     * @return mixed|void
     */
    public function setProperties($data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $this->setProperties($value);
                unset($this->{$key});
                continue;
            }
            $this->{$key} = $value;
        }
    }
}