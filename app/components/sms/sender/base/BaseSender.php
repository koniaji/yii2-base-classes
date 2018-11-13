<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 26.12.17
 * Time: 17:46
 */

namespace Zvinger\BaseClasses\app\components\sms\sender\base;

use Zvinger\BaseClasses\app\components\sms\models\SmsSendData;

abstract class BaseSender
{
    abstract protected function sendByService(SmsSendData $data);

    public function send(SmsSendData $data)
    {
        return $this->sendByService($data);
    }
}