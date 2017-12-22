<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 20.12.17
 * Time: 18:08
 */

namespace Zvinger\BaseClasses\app\modules\api\base\controllers;

use app\components\user\identity\UserIdentity;
use \Zvinger\BaseClasses\app\components\user\token\UserTokenHandler;
use app\models\work\user\object\UserObject;
use Zvinger\BaseClasses\app\modules\api\base\responses\auth\BaseAuthLoginResponse;
use yii\web\UnauthorizedHttpException;
use Zvinger\BaseClasses\api\controllers\BaseApiController;


class AuthController extends BaseApiController
{
    /**
     * @SWG\Post(path="/auth/login",
     *     tags={"Auth"},
     *     summary="Initial bearer token login",
     *     @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          required=true,
     *          @SWG\Schema(
     *              @SWG\Property(
     *                  property="username",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="password",
     *                  type="string"
     *              )
     *          )
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "Success response",
     *         @SWG\Schema(ref = "#/definitions/BaseAuthLoginResponse")
     *     ),
     * )
     * @throws \yii\web\BadRequestHttpException
     * @throws \yii\base\Exception
     */
    public function actionLogin()
    {
        $username = $this->checkAndGet('username');
        $password = $this->checkAndGet('password');
        $user = UserObject::find()->andWhere(['or', ['username' => $username], ['email' => $username]])->one();

        if (!$user->validatePassword($password)) {
            throw new UnauthorizedHttpException("Wrong username or password");
        }
        $identity = UserIdentity::findIdentity($user->id);
        $handler = new UserTokenHandler($identity->getId());
        $tokenObject = $handler->generateBearerToken();

        return \Yii::configure(new BaseAuthLoginResponse(), [
            'token' => $tokenObject->token,
            'user'  => $tokenObject->user_id,
        ]);
    }
}