<?php
/**
 * Created by PhpStorm.
 * User: amorev
 * Date: 10.03.2019
 * Time: 14:50
 */

namespace Zvinger\BaseClasses\app\graphql\helpers;


class BaseTypesCollection
{
    private static $fields = [];

    public static function getField($class, $name = null, $constructVars = [])
    {
        if (empty($name)) {
            $name = md5($class.json_encode(serialize($constructVars)));
        }

        return self::$fields[$name] ?: (self::$fields[$name] = \Yii::createObject($class, $constructVars));
    }
}
