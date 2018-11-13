<?php

namespace Zvinger\BaseClasses\app\models\work\user\activation;

use Yii;
use Zvinger\BaseClasses\app\models\db\user\activation\DBUserActivationObject;

/**
 * This is the model class for table "user_activation".
 *
 * @property int $user_id
 * @property string $activation_type
 * @property string $activation_hash
 * @property int $active
 */
class VendorUserActivationObject extends DBUserActivationObject
{
    public $tempCode;
    /**
     * @return VendorUserActivationQuery
     */
    public static function find()
    {
        return new VendorUserActivationQuery(get_called_class());
    }
}
