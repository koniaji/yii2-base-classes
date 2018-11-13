<?php

namespace Zvinger\BaseClasses\app\components\user\behaviors;

use app\models\work\user\object\UserObject;
use yii\base\Behavior;
use yii\web\User;
use Zvinger\BaseClasses\app\components\user\VendorUserHandlerComponent;
use Zvinger\BaseClasses\app\models\db\user\object\DBUserObject;

class LoginTimestampBehavior extends Behavior
{
    public $userHandlerComponentName = 'userHandler';

    /**
     * @var string
     */
    public $attribute = 'logged_at';


    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            User::EVENT_AFTER_LOGIN => 'afterLogin',
        ];
    }

    /**
     * @param $event \yii\web\UserEvent
     */
    public function afterLogin($event)
    {
        /** @var VendorUserHandlerComponent $obj */
        $obj = \Yii::$app->get($this->userHandlerComponentName);
        $obj->updateOnline($event->identity->getId());
    }
}
