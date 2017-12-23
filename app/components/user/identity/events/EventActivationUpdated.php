<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 23.12.17
 * Time: 0:55
 */

namespace Zvinger\BaseClasses\app\components\user\identity\events;

use yii\base\Event;

class EventActivationUpdated extends Event
{
    public $userObject;
}