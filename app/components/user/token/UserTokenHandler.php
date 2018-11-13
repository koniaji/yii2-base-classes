<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 20.12.17
 * Time: 18:28
 */

namespace Zvinger\BaseClasses\app\components\user\token;

use app\models\work\user\token\bearer\UserBearerTokenObject;
use yii\base\Exception;

class UserTokenHandler
{
    /**
     * @var int
     */
    private $_user_id;

    /**
     * UserTokenHandler constructor.
     * @param $_user_id
     */
    public function __construct($_user_id)
    {
        $this->_user_id = $_user_id;
    }

    /**
     * @throws \yii\base\Exception
     */
    public function generateBearerToken()
    {
        $object = new UserBearerTokenObject();
        $object->user_id = $this->_user_id;
        $object->status = $object::STATUS_ACTIVE;
        $token = NULL;
        while (!UserBearerTokenObject::checkTokenValid($token)) {
            $token = \Yii::$app->security->generateRandomString(64);
        }
        $object->token = $token;
        $result = $object->save();
        if (!$result) {
            throw new Exception(print_r($object->firstErrors, TRUE));
        }

        return $object;
    }

    public function invalidateAllOldTokens()
    {
        UserBearerTokenObject::deleteAll(['user_id' => $this->_user_id]);
    }
}