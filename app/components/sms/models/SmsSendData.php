<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 26.12.17
 * Time: 17:36
 */

namespace Zvinger\BaseClasses\app\components\sms\models;

use yii\base\BaseObject;

class SmsSendData extends BaseObject
{
    public $phone;

    public $message;
}