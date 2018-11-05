<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 20.08.18
 * Time: 18:48
 */

namespace Zvinger\BaseClasses\app\components\data\filterInfo\models;

class FilterArrayElement extends BaseFilterElement
{
    protected static $type = self::ARRAY;

    /*
     * не помню зачем это ввел)
     */
    public $arrayPush = true;
}