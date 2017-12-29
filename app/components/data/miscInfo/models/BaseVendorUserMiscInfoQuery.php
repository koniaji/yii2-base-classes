<?php

namespace Zvinger\BaseClasses\app\components\data\miscInfo\models;

/**
 * This is the ActiveQuery class for [[UserMiscInfoObject]].
 *
 * @see BaseVendorMiscInfoObject
 */
class BaseVendorUserMiscInfoQuery extends \yii\db\ActiveQuery
{
    public function byKey($key)
    {
        return $this->andWhere(['key' => $key]);
    }

    public function byObject($object_id)
    {
        return $this->andWhere(['object_id' => $object_id]);
    }

    public function byType($type)
    {
        return $this->andWhere(['object_type' => $type]);
    }

    /**
     * @inheritdoc
     * @return BaseVendorMiscInfoObject[]|array
     */
    public function all($db = NULL)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BaseVendorMiscInfoObject|array|null
     */
    public function one($db = NULL)
    {
        return parent::one($db);
    }
}
