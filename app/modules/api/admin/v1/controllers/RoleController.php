<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 24.04.18
 * Time: 13:33
 */

namespace Zvinger\BaseClasses\app\modules\api\admin\v1\controllers;


use Zvinger\BaseClasses\app\modules\api\admin\v1\actions\role\index\RoleIndexResponse;
use Zvinger\BaseClasses\app\modules\api\admin\v1\controllers\base\BaseVendorAdminV1Controller;

class RoleController extends BaseVendorAdminV1Controller
{
    /**
     * @SWG\GET(path="/vendor/roles",
     *     tags={"user"},
     *     summary="Получение списка ролей",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Список ролей",
     *         @SWG\Schema(ref = "#/definitions/RoleIndexResponse")
     *     ),
     * )
     */
    public function actionIndex()
    {
        $response = new RoleIndexResponse();
        $roles = \Yii::$app->authManager->getRoles();
        $response->roles = array_keys($roles);

        return $response;
    }
}