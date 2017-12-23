<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 23.12.17
 * Time: 0:31
 */

namespace Zvinger\BaseClasses\app\components\user\identity\handlers;

use Zvinger\BaseClasses\app\models\work\user\object\VendorUserObject;

abstract class BaseUserHandler
{
    /**
     * @var int
     */
    private $_user_id;

    /**
     * @var VendorUserObject
     */
    private $_user_object;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        if (empty($this->_user_id)) {
            $this->_user_id = $this->_user_object->id;
        }

        return $this->_user_id;
    }

    /**
     * @param int $user_id
     * @return $this
     */
    public function setUserId(int $user_id)
    {
        $this->_user_id = $user_id;

        return $this;
    }

    /**
     * @return VendorUserObject
     */
    public function getUserObject(): VendorUserObject
    {
        if (empty($this->_user_object)) {
            $this->_user_object = VendorUserObject::findOne($this->_user_id);
        }

        return $this->_user_object;
    }

    /**
     * @param VendorUserObject $user_object
     * @return $this
     */
    public function setUserObject(VendorUserObject $user_object)
    {
        $this->_user_object = $user_object;

        return $this;
    }
}