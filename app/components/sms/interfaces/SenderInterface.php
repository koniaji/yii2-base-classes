<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 26.12.17
 * Time: 17:43
 */

namespace Zvinger\BaseClasses\app\components\sms\interfaces;

use Zvinger\BaseClasses\app\components\email\models\SendData;

interface SenderInterface
{
    public function send(SendData $data);
}