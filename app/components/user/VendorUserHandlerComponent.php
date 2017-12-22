<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 22.12.17
 * Time: 11:56
 */

namespace Zvinger\BaseClasses\app\components\user;

use Zvinger\BaseClasses\app\components\user\events\UserCreatedEvent;
use Zvinger\BaseClasses\app\components\user\identity\handlers\UserCreateHandler;
use yii\base\BaseObject;
use yii\base\Component;

class VendorUserHandlerComponent extends Component
{
    const EVENT_USER_CREATED = 'event_user_created';

    public function createUser($email, $password, $username = NULL)
    {
        $handler = new UserCreateHandler();
        \Yii::configure($handler, [
            'username' => $username,
            'email'    => $email,
            'password' => $password,
        ]);

        $userObject = $handler->createUser();
        $this->trigger(self::EVENT_USER_CREATED, new UserCreatedEvent(['user' => $userObject]));

        return $userObject;
    }
}