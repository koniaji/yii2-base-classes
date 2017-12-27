<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 22.12.17
 * Time: 11:56
 */

namespace Zvinger\BaseClasses\app\components\user;

use app\components\user\identity\UserIdentity;
use app\models\work\user\object\UserObject;
use Zvinger\BaseClasses\app\components\user\events\UserCreatedEvent;
use Zvinger\BaseClasses\app\components\user\exceptions\UserCreateException;
use Zvinger\BaseClasses\app\components\user\exceptions\UserLoginException;
use Zvinger\BaseClasses\app\components\user\identity\handlers\UserActivateHandler;
use Zvinger\BaseClasses\app\components\user\identity\handlers\UserCreateHandler;
use yii\base\BaseObject;
use yii\base\Component;
use Zvinger\BaseClasses\app\components\user\identity\VendorUserIdentity;

class VendorUserHandlerComponent extends Component
{
    const EVENT_USER_CREATED = 'event_user_created';

    /**
     * @var string|UserObject
     */
    public $userObjectClass = UserObject::class;

    /**
     * @param $email
     * @param $password
     * @param null $username
     * @return UserObject
     * @throws \Exception
     * @throws UserCreateException
     */
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

    /**
     * @param $email
     * @param $password
     * @param null $username
     * @return null|\yii\web\IdentityInterface|static
     * @throws UserLoginException
     * @throws \yii\base\Exception
     */
    public function loginUser($email, $password, $username = NULL)
    {
        $user = UserObject::find()->andWhere(['or', ['username' => $username], ['email' => $email]])->one();

        if (empty($user) || !$user->validatePassword($password)) {
            throw new UserLoginException("Wrong username or password");
        }
        /** @var VendorUserIdentity $identityClass */
        $identityClass = \Yii::$app->user->identityClass;
        $identity = $identityClass::findIdentity($user->id);

        return $identity;
    }

    /**
     * @param $user_id
     * @param $code
     * @param string $activation_type
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function activateUser($user_id, $code, $activation_type = 'default')
    {
        $handler = new UserActivateHandler();
        $handler->setUserId($user_id);
        $handler->activate($code, $activation_type);
    }
}