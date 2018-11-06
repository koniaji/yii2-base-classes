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
use Zvinger\BaseClasses\app\modules\api\base\requests\auth\ResetPasswordInitRequest;
use Zvinger\BaseClasses\app\modules\api\base\responses\auth\BaseAuthLoginResponse;
use yii\web\UnauthorizedHttpException;
use Zvinger\BaseClasses\api\controllers\BaseApiController;
use Zvinger\BaseClasses\app\modules\api\base\responses\auth\ResetPasswordInitResponse;
use Zvinger\BaseClasses\app\modules\api\base\responses\auth\SavePasswordResponse;


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

        if (empty($user) || !$user->validatePassword($password)) {
            throw new UnauthorizedHttpException("Wrong username or password");
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

    /**
     * @SWG\Post(
     *     path="/auth/reset-password-init",
     *     tags = {"LK"},
     *     @SWG\Parameter(
     *          in="body",
     *          name="body",
     *          @SWG\Schema(ref = "#/definitions/ResetPasswordInitRequest")
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "",
     *         @SWG\Schema(ref = "#/definitions/ResetPasswordInitResponse")
     *     ),
     * )
     * @param string $lang
     * @return ResetPasswordInitResponse
     * @throws \yii\base\InvalidConfigException
     */
    public function actionResetPasswordInit()
    {
        return \Yii::createObject(
            [
                'class' => ResetPasswordInitResponse::class,
                'success' => true,
            ]
        );
    }

    /**
     * @SWG\Post(
     *     path="/auth/reset-password-confirm",
     *     tags = {"LK"},
     *     @SWG\Parameter(
     *          in="body",
     *          name="body",
     *          @SWG\Schema(ref = "#/definitions/ResetPasswordConfirmRequest")
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "",
     *         @SWG\Schema(ref = "#/definitions/ResetPasswordInitResponse")
     *     ),
     * )
     * @param string $lang
     * @return ResetPasswordInitResponse
     * @throws \yii\base\InvalidConfigException
     */
    public function actionResetPasswordConfirm()
    {
        return \Yii::createObject(
            [
                'class' => ResetPasswordInitResponse::class,
                'success' => true,
            ]
        );
    }

    /**
     * @SWG\Post(
     *     path="/auth/save-password",
     *     tags = {"LK"},
     *     @SWG\Parameter(
     *          in="body",
     *          name="body",
     *          @SWG\Schema(ref = "#/definitions/SavePasswordRequest")
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "",
     *         @SWG\Schema(ref = "#/definitions/SavePasswordResponse")
     *     ),
     * )
     * @param string $lang
     * @return ResetPasswordInitResponse
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSavePassword()
    {
        return \Yii::createObject(
            [
                'class' => SavePasswordResponse::class,
                'token' => '123',
            ]
        );
    }
}