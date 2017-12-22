<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 20.12.17
 * Time: 19:19
 */

namespace Zvinger\BaseClasses\app\modules\api\admin\v1\controllers;

use Zvinger\BaseClasses\app\helpers\error\ErrorMessageHelper;
use app\models\work\user\object\UserObject;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\OptionsAction;
use yii\web\BadRequestHttpException;
use Zvinger\BaseClasses\api\controllers\BaseApiController;

class UserController extends BaseApiController
{
    public function actions()
    {
        return [
            'options' => [
                'class' => OptionsAction::class,
            ],
        ];
    }

    public function behaviors()
    {
        $old = parent::behaviors();
        $behaviors = [];
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        $array_merge = array_merge($old, $behaviors);

        return $array_merge;
    }


    public function actionIndex()
    {
        return UserObject::find()->all();
    }

    public function actionView($id)
    {
        return UserObject::findOne($id);
    }

    /**
     * @param $id
     * @return object
     * @throws BadRequestHttpException
     */
    public function actionUpdate($id)
    {
        $user = UserObject::findOne($id);
        $user->load(\Yii::$app->request->post(), '');
        if (!$user->save()) {
            throw new BadRequestHttpException(new ErrorMessageHelper($user));
        }
        return $user;
    }
}