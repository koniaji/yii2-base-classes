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
use yii\base\Component;
use yii\web\UnauthorizedHttpException;
use Zvinger\BaseClasses\app\components\user\token\UserTokenHandler;
use Zvinger\BaseClasses\app\modules\api\base\requests\auth\LoginRequest;
use Zvinger\BaseClasses\app\modules\api\base\responses\auth\BaseAuthLoginResponse;
use Zvinger\GoogleOtp\components\google\GoogleAuthenticatorComponent;

class LoginComponent extends Component
{

    public function run(LoginRequest $request)
    {
        $user = UserObject::find()->andWhere(
            ['or',
                ['username' => $request->username],
                ['email' => $request->username]
            ])->one();

        if (empty($user) || !$user->validatePassword($request->password)) {
            throw new UnauthorizedHttpException("Wrong username or password");
        }

        $this->checkGoogle2FACode($user->id, $request->special);

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

    private function checkGoogle2FACode($userId, $special)
    {

        $googleAuthenticatorComponent = new GoogleAuthenticatorComponent();

        if ($googleAuthenticatorComponent->getUserGoogleAuthStatus($userId)) {

            if (!isset($special['google2FACode'])) {
                throw new UnauthorizedHttpException("Google 2fa code not found");
            }

            $code = $special['google2FACode'];
            $result = $googleAuthenticatorComponent->validateUserCode($userId, $code);

            if (!$result) {
                throw new UnauthorizedHttpException("Invalid google 2fa code");
            }

        }

    }

}
