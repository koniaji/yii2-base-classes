<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 22.12.17
 * Time: 12:01
 */

namespace Zvinger\BaseClasses\app\components\user\events;

use yii\base\Event;

class UserCreatedEvent extends Event
{
    public $user;


}