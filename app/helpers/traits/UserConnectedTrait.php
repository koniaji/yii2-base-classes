<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 05.10.17
 * Time: 8:48
 */

namespace Zvinger\BaseClasses\app\helpers;

use Zvinger\BaseClasses\app\helpers\misc\AbstractDataConnectionMaker;
use Zvinger\BaseClasses\app\models\db\user\object\DBUserObject;

trait UserConnectedTrait
{
    /**
     * @var DBUserObject
     */
    private $_user;

    private $_user_id;

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return AbstractDataConnectionMaker::getId($this->_user_id, $this->_user);
    }

    /**
     * @param mixed $booking_id
     * @return $this
     */
    public function setUserId($booking_id)
    {
        $this->_user_id = $booking_id;

        return $this;
    }


    /**
     * @return DBUserObject
     */
    public function getUser()
    {
        return AbstractDataConnectionMaker::getObject($this->_user_id, $this->_user, DBUserObject::class);
    }

    /**
     * @param mixed $order
     * @return $this
     */
    public function setUser(DBUserObject $order)
    {
        $this->_user = $order;

        return $this;
    }
}