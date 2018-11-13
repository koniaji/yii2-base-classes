<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 01.02.18
 * Time: 16:57
 */

namespace Zvinger\BaseClasses\app\helpers\log;

abstract class BaseLogClass
{
    public static $logCategory = 'app';

    public static function info($message)
    {
        \Yii::info($message, static::$logCategory);
    }

    public static function error($message)
    {
        \Yii::error($message, static::$logCategory);
    }

    public static function warning($message)
    {
        \Yii::warning($message, static::$logCategory);
    }
}