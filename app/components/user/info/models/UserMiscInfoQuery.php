<?php

namespace Zvinger\BaseClasses\app\components\user\info\models;

/**
 * This is the ActiveQuery class for [[UserMiscInfoObject]].
 *
 * @see UserMiscInfoObject
 */
class UserMiscInfoQuery extends \yii\db\ActiveQuery
{
    public function byKey($key)
    {
        return $this->andWhere(['key' => $key]);
    }

    public function byUser($user_id)
    {
        return $this->andWhere(['user_id' => $user_id]);
    }

    /**
     * @inheritdoc
     * @return UserMiscInfoObject[]|array
     */
    public function all($db = NULL)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return UserMiscInfoObject|array|null
     */
    public function one($db = NULL)
    {
        return parent::one($db);
    }
}
