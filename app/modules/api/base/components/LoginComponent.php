<?php
/**
 * Created by PhpStorm.
 * User: nik
 * Date: 20.05.19
 * Time: 11:13
 */

namespace Zvinger\BaseClasses\app\modules\api\base\components;

use app\components\user\identity\UserIdentity;
use app\models\work\user\object\UserObject;
use app\modules\api\base\exceptions\GoogleAuthenticatorNotFound;
use yii\base\Component;
use yii\web\UnauthorizedHttpException;
use Zvinger\BaseClasses\app\components\user\token\UserTokenHandler;
use Zvinger\BaseClasses\app\modules\api\base\requests\auth\LoginRequest;
use Zvinger\BaseClasses\app\modules\api\base\responses\auth\BaseAuthLoginResponse;

class LoginComponent extends Component
{
    public $google2FA = false;

    public function run(LoginRequest $request): BaseAuthLoginResponse
    {
        $user = UserObject::find()->andWhere(
            ['or',
                ['username' => $request->username],
                ['email' => $request->username]
            ])->one();

        if (empty($user) || !$user->validatePassword($request->password)) {
            throw new UnauthorizedHttpException("Wrong username or password");
        }

        if ($this->google2FA) {
            $google2FACode = $request->special['google2FACode'] ?: false;
            $this->checkGoogle2FACode($user->id, $google2FACode);
        }

        $identity = UserIdentity::findIdentity($user->id);
        $handler = new UserTokenHandler($identity->getId());
        $tokenObject = $handler->generateBearerToken();

        return \Yii::configure(
            new BaseAuthLoginResponse(),
            [
                'token' => $tokenObject->token,
                'user' => $tokenObject->user_id,
            ]
        );
    }

    private function checkGoogle2FACode($userId, $google2FACode)
    {
        if (!class_exists('Zvinger\GoogleOtp\components\google\GoogleAuthenticatorComponent')) {
            throw new GoogleAuthenticatorNotFound();
        }
        $googleAuthenticatorComponent = new Zvinger\GoogleOtp\components\google\GoogleAuthenticatorComponent();

        if ($googleAuthenticatorComponent->getUserGoogleAuthStatus($userId)) {

            if (!$google2FACode) {
                throw new UnauthorizedHttpException("Google 2fa code not found");
            }

            $result = $googleAuthenticatorComponent->validateUserCode($userId, $google2FACode);

            if (!$result) {
                throw new UnauthorizedHttpException("Invalid google 2fa code");
            }

        }

    }

}
