<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 19.02.18
 * Time: 15:25
 */

namespace Zvinger\BaseClasses\app\components\keyStorage\models;

use yii\helpers\Json;

abstract class BaseKeyStorageElement
{
    public function prepareForStorage()
    {
        return Json::encode($this);
    }

    public static function formatFromStorage($value)
    {
        return Json::decode($value);
    }

    public static function createFromStorage($data)
    {
        $object = new static();

        if (!empty($data)) {
            return \Yii::configure($object, $data);
        }

        return $object;
    }

    final public static function getFromStorage($key)
    {
        $data = static::formatFromStorage(\Yii::$app->keyStorage->get(static::prepareKey($key)));

        return static::createFromStorage($data);
    }

    public static function getBaseStorageKey(): string
    {
        return get_called_class();
    }

    final public static function prepareKey($key)
    {
        return static::getBaseStorageKey() . $key;
    }

    final public function saveToStorage($key)
    {
        return static::getKeyStorageComponent()->set(static::prepareKey($key), $this->prepareForStorage());
    }

    public static function removeFromStorage($key)
    {
        static::getKeyStorageComponent()->remove(static::prepareKey($key));
    }

    /**
     * @return mixed|\Zvinger\BaseClasses\app\components\keyStorage\KeyStorageComponent
     */
    public static function getKeyStorageComponent()
    {
        return \Yii::$app->keyStorage;
    }
}