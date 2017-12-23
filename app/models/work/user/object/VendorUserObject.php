<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 19.12.17
 * Time: 18:42
 */

namespace Zvinger\BaseClasses\app\models\work\user\object;

use Zvinger\BaseClasses\app\components\user\identity\attributes\status\SingleUserStatus;
use Zvinger\BaseClasses\app\components\user\identity\attributes\status\StatusHandler;
use Zvinger\BaseClasses\app\components\user\identity\attributes\status\UserStatusAttribute;
use Zvinger\BaseClasses\app\models\db\user\object\DBUserObject;
use Zvinger\BaseClasses\app\models\work\user\activation\VendorUserActivationObject;
use Zvinger\BaseClasses\app\models\work\user\token\bearer\UserBearerTokenObject;
use yii\behaviors\TimestampBehavior;

/**
 * Class UserObject
 * @package Zvinger\BaseClasses\app\models\work\user\object
 *
 * @property string password
 */
class VendorUserObject extends DBUserObject
{
    const EVENT_ACTIVATION_UPDATED = 'event_activation_updated';

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

    public function rules()
    {
        $baseRules = parent::rules(); // TODO: Change the autogenerated stub
        $baseRules[] =
            [
                ['email'],
                'email',
            ];

        return $baseRules;
    }


    /**
     * @param $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @param $password
     * @return bool
     * @throws \yii\base\Exception
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @return SingleUserStatus
     */
    public function getStatusObject()
    {
        return (new StatusHandler())->setStatusId($this->status)->getStatusObject();
    }

    public function getUserBearerTokens()
    {
        return $this->hasMany(UserBearerTokenObject::class, ['user_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            if (empty($this->status)) {
                $this->status = UserStatusAttribute::getUserCreateStatus();
            }
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }


    /**
     * @return VendorUserQuery
     */
    public static function find()
    {
        return new VendorUserQuery(get_called_class());
    }

    public function getUserActivations()
    {
        return $this->hasMany(VendorUserActivationObject::class, [
            'user_id' => 'id',
        ]);
    }
}