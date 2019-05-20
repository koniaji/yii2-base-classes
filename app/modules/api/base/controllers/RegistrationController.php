<?php
/**
 * Created by PhpStorm.
 * User: nik
 * Date: 16.05.19
 * Time: 11:01
 */

namespace Zvinger\BaseClasses\app\modules\api\base\controllers;

use Zvinger\BaseClasses\app\modules\api\base\requests\registration\RegistrationRequest;


class RegistrationController extends Controllerr
{
    public function actionIndex()
    {
        $requst = new RegistrationRequest();
        return $this->module->registrationComponent->run($requst::createRequest());
    }

}
