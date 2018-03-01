<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 24.12.17
 * Time: 0:07
 */

namespace Zvinger\BaseClasses\api\actions\activation;

use app\modules\api\lawyer\v1\controllers\AccountController;
use yii\base\Action;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

class ConfirmUserAction extends Action
{
    public $type;

    /**
     * @var AccountController
     */
    public $controller;

    /**
     * @throws BadRequestHttpException
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $checkCode = \Yii::$app->request->post('checkCode');
        if (empty(\Yii::$app->user->id)) {
            throw new UnauthorizedHttpException();
        }
        if (empty($checkCode)) {
            throw new BadRequestHttpException("Empty check code");
        }
        $authComponent = $this->controller->module->authComponent;
        $authComponent->confirmUser(\Yii::$app->user->id, $this->type, $checkCode);
    }
}