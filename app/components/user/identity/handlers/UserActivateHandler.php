<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 23.12.17
 * Time: 0:31
 */

namespace Zvinger\BaseClasses\app\components\user\identity\handlers;

use yii\base\Event;
use Zvinger\BaseClasses\app\components\user\exceptions\WrongActivationCodeException;
use Zvinger\BaseClasses\app\components\user\identity\events\EventActivationUpdated;
use Zvinger\BaseClasses\app\models\work\user\activation\VendorUserActivationObject;
use Zvinger\BaseClasses\app\models\work\user\object\VendorUserObject;

class UserActivateHandler extends BaseUserHandler
{
    const HASH_KEY = 'key_activation_user';

    /**
     * @param $code
     * @param $activation_type
     * @return bool
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function activate($code, $activation_type)
    {
        $object = $this->getActivationObject($activation_type);
        if (empty($object)) {
            throw new \Exception("Empty activation object: " . print_r([
                    'user_id' => $this->getUserId(),
                    'type'    => $activation_type,
                ]));
        }

        if (!\Yii::$app->security->compareString($this->createHash($code), $object->activation_hash)) {
            throw new WrongActivationCodeException();
        }

        $object->active = 1;
        $object->save();
        Event::trigger(VendorUserObject::class, VendorUserObject::EVENT_ACTIVATION_UPDATED, new EventActivationUpdated(['userObject' => $this->getUserObject()]));

        return TRUE;
    }

    public function getActivationObject($activation_type)
    {
        return VendorUserActivationObject::find()->byUser($this->getUserId())->byType($activation_type)->one();
    }

    /**
     * @param $activation_type
     * @return VendorUserActivationObject
     * @throws \yii\base\InvalidConfigException
     */
    public function createActivationObject($activation_type)
    {
        $code = $this->createCode();
        $hash = $this->createHash($code);
        $object = $this->getActivationObject($activation_type);
        if (empty($object)) {
            $object = new VendorUserActivationObject([
                'activation_type' => $activation_type,
                'user_id'         => $this->getUserId(),
                'active'          => 0,
            ]);
        }
        $object->activation_hash = $hash;
        $object->tempCode = $code;
        $object->save();

        return $object;
    }

    public function createCode()
    {
        return rand(100000, 999999);
    }

    /**
     * @param $code
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    private function createHash($code): string
    {
        return \Yii::$app->security->hashData($this->getUserId() . '.' . $code, static::HASH_KEY);
    }
}