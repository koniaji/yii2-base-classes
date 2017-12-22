<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 20.12.17
 * Time: 11:09
 */

namespace Zvinger\BaseClasses\app\components\user\identity;

use app\models\work\user\object\UserObject;
use yii\base\BaseObject;
use yii\web\IdentityInterface;

class VendorUserIdentity extends BaseObject implements IdentityInterface
{
    /**
     * @var UserObject
     */
    private $_user_object;

    /**
     * @var int
     */
    private $_user_id;

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $object = new static;
        $object->setUserId($id);

        return $object;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = NULL)
    {
        $object = UserObject::find()->byToken($token)->one();
        $identity = new static;
        $identity->setUserId($object->id);
        $identity->setUserObject($object);

        return $identity;
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->_user_id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->getUserObject()->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @param int $user_id
     * @return VendorUserIdentity
     */
    public function setUserId($user_id)
    {
        $this->_user_id = $user_id;

        return $this;
    }

    /**
     * @return UserObject
     */
    public function getUserObject()
    {
        if (empty($this->_user_object)) {
            $this->_user_object = UserObject::findOne($this->_user_id);
        }

        return $this->_user_object;
    }

    /**
     * @param UserObject $user_object
     */
    public function setUserObject(UserObject $user_object): void
    {
        $this->_user_object = $user_object;
    }
}