<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 20.12.17
 * Time: 10:18
 */

namespace Zvinger\BaseClasses\app\models\work\user\token\bearer;

use Zvinger\BaseClasses\app\models\db\user\token\bearer\DBUserBearerTokenObject;
use Zvinger\BaseClasses\app\models\work\user\object\VendorUserObject;
use yii\behaviors\TimestampBehavior;

/**
 * @property VendorUserObject $user
 */
class UserBearerTokenObject extends DBUserBearerTokenObject
{
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public static function checkTokenValid($token)
    {
        return !empty($token) && static::find()->andWhere(['token' => $token])->count() == 0;
    }
}