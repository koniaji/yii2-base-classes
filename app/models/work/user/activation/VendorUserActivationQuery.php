<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 23.12.17
 * Time: 0:25
 */

namespace Zvinger\BaseClasses\app\models\work\user\activation;

use yii\db\ActiveQuery;

/**
 * Class VendorUserActionQuery
 * @package Zvinger\BaseClasses\app\models\work\user\activation
 * @see VendorUserActivationObject
 */
class VendorUserActivationQuery extends ActiveQuery
{
    /**
     * @param $user_id
     * @return $this
     */
    public function byUser($user_id)
    {
        return $this->andWhere(['user_id'=>$user_id]);
    }

    /**
     * @param $type
     * @return $this
     */
    public function byType($type)
    {
        return $this->andWhere(['activation_type'=>$type]);
    }

    /**
     * @param null $db
     * @return array|VendorUserActivationObject[]
     */
    public function all($db = NULL)
    {
        return parent::all($db);
    }

    /**
     * @param null $db
     * @return array|VendorUserActivationObject
     */
    public function one($db = NULL)
    {
        return parent::one($db);
    }


}