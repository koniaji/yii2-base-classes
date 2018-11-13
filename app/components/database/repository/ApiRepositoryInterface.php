<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 05.05.18
 * Time: 14:43
 */

namespace Zvinger\BaseClasses\app\components\database\repository;


use yii\db\ActiveRecord;

interface ApiRepositoryInterface
{
    /**
     * @param ActiveRecord $object
     * @return callable|array
     */
    public function fillApiModelFromObject($object);

    /**
     * @param ActiveRecord $object
     * @param $model
     * @return ActiveRecord
     */
    public function fillObjectFromApiModel($object, $model);
}