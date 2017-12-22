<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 20.12.17
 * Time: 15:42
 */

namespace Zvinger\BaseClasses\app\components\user\identity\attributes\status;

use yii\helpers\ArrayHelper;

class UserStatusAttribute
{
    const STATUS_CREATED = 1;
    const STATUS_ACTIVATED = 2;
    const STATUS_DELETED = 3;

    public static $statusList = [
        [
            'id'  => self::STATUS_CREATED,
            'key' => 'created',
        ],
        [
            'id'  => self::STATUS_ACTIVATED,
            'key' => 'activated',
        ],
        [
            'id'  => self::STATUS_DELETED,
            'key' => 'deleted',
        ],
    ];

    /**
     * @var SingleUserStatus[]
     */
    private static $_statusesById = [];

    /**
     * @param null $id
     * @return SingleUserStatus[]|SingleUserStatus
     */
    public static function getStatusesById($id = NULL)
    {
        if (empty(static::$_statusesById)) {
            foreach (static::getStatusObjects() as $item) {
                static::$_statusesById[$item->id] = $item;
            }
        }

        if (!empty($key)) {
            return ArrayHelper::getValue(static::$_statusesById, $key);
        }

        return static::$_statusesById;
    }

    /**
     * @var SingleUserStatus[]
     */
    private static $_statusesByKey = [];

    /**
     * @param null $key
     * @return SingleUserStatus[]|SingleUserStatus
     */
    public static function getStatusesByKey($key = NULL)
    {
        if (empty(static::$_statusesByKey)) {
            foreach (static::getStatusObjects() as $item) {
                static::$_statusesByKey[$item->key] = $item;
            }
        }

        if (!empty($key)) {
            return ArrayHelper::getValue(static::$_statusesByKey, $key);
        }

        return static::$_statusesByKey;
    }

    /**
     * @var SingleUserStatus[]
     */
    private static $_statusObjects = [];

    /**
     * @return SingleUserStatus[]
     */
    protected static function getStatusObjects()
    {
        if (empty(static::$_statusObjects)) {
            foreach (static::$statusList as $item) {
                $object = new SingleUserStatus();
                foreach ($item as $key => $value) {
                    $object->{$key} = $value;
                }
                static::$_statusObjects[] = $object;
            }
        }

        return static::$_statusObjects;
    }

    public static function getUserCreateStatus()
    {
        return static::STATUS_CREATED;
    }
}