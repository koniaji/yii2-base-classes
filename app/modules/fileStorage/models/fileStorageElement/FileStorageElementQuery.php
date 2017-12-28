<?php

namespace Zvinger\BaseClasses\app\modules\fileStorage\models\fileStorageElement;

/**
 * This is the ActiveQuery class for [[FileStorageElementObject]].
 *
 * @see FileStorageElementObject
 */
class FileStorageElementQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FileStorageElementObject[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FileStorageElementObject|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
