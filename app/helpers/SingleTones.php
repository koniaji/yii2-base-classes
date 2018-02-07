<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 22.11.17
 * Time: 11:46
 */

namespace Zvinger\BaseClasses\app\helpers;

abstract class SingleTones
{
    /**
     * @var array[]
     */
    protected static $_instances;

    private function __construct()
    {
    }

    /**
     * @return static
     */
    public static function getInstance()
    {
        $calledClass = get_called_class();
        $object = static::$_instances[$calledClass];
        if (self::$_instances[$calledClass] === NULL) {
            $object = new static;
            $object->configure();
            self::$_instances[$calledClass] = $object;
        }

        return $object;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    protected function configure()
    {
    }
}