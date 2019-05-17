<?php
/**
 * Created by PhpStorm.
 * User: nik
 * Date: 16.05.19
 * Time: 11:01
 */

namespace Zvinger\BaseClasses\app\modules\api\base\controllers;


use app\models\work\user\object\UserObject;
use Zvinger\BaseClasses\app\components\user\VendorUserHandlerComponent;
use Zvinger\BaseClasses\app\modules\api\base\requests\registration\CreateUserRequest;


class RegistrationController
{
    public function actionCreateUser()
    {
        $request = CreateUserRequest::createRequest();
        $user = (new VendorUserHandlerComponent)
            ->createUser($request->email, $request->password, $request->login, $request->special);
        if ($user) {
            return true;
        }

    }

}
