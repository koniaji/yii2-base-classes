<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 30.08.17
 * Time: 16:40
 */

namespace Zvinger\BaseClasses\app\helpers\misc;

use yii\db\ActiveRecord;

class AbstractDataConnectionMaker
{
    /**
     * @param $id
     * @param $object ActiveRecord
     * @return mixed
     */
    public static function getId(&$id, $object)
    {
        if (empty($id)) {
            if (!empty($object)) {
                $id = $object->primaryKey;
            }
        }

        return $id;
    }

    /**
     * @param $id
     * @param $object ActiveRecord
     * @param $objectClass ActiveRecord|mixed
     * @return ActiveRecord|mixed
     */
    public static function getObject($id, &$object, $objectClass)
    {
        if (empty($object)) {
            if (!empty($id)) {
                $object = $objectClass::findOne($id);
            }
        }

        return $object;
    }
}