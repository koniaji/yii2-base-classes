<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 20.12.17
 * Time: 15:59
 */

namespace Zvinger\BaseClasses\app\components\user\identity\attributes\status;

class StatusHandler
{
    private $_status_id;

    /**
     * @param mixed $status_id
     * @return StatusHandler
     */
    public function setStatusId($status_id)
    {
        $this->_status_id = $status_id;

        return $this;
    }

    /**
     * @return SingleUserStatus
     */
    public function getStatusObject()
    {
        return UserStatusAttribute::getStatusesById($this->_status_id);
    }
}