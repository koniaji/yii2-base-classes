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
use Zvinger\BaseClasses\app\models\work\user\object\VendorUserObject;
use Zvinger\BaseClasses\app\modules\api\admin\v1\components\user\models\UserApiAdminV1Model;
use Zvinger\BaseClasses\app\modules\api\admin\v1\controllers\base\BaseVendorAdminV1Controller;

class UserController extends BaseVendorAdminV1Controller
{
    public function actionIndex()
    {
        return $this->module->userComponent->convertUserObjectsToModelMultiple(VendorUserObject::find()->all());
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

        return $this->module->userComponent->convertUserObjectToModel($user);
    }

    /**
     * @return UserApiAdminV1Model
     * @throws BadRequestHttpException
     */
    public function actionCreate()
    {
        $user = new UserObject(\Yii::$app->request->post());

        if (!$user->save()) {
            throw new BadRequestHttpException(new ErrorMessageHelper($user));
        }

        return $this->module->userComponent->convertUserObjectToModel($user);
    }
}