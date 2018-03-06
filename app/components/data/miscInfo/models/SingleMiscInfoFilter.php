<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 06.03.18
 * Time: 15:38
 */

namespace Zvinger\BaseClasses\app\components\data\miscInfo\models;

class SingleMiscInfoFilter
{
    public $key;

    public $filter;

    /**
     * SingleMiscInfoFilter constructor.
     * @param $key
     * @param $filter
     */
    public function __construct($key, $filter)
    {
        $this->key = $key;
        $this->filter = $filter;
    }


}