<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 22.12.17
 * Time: 11:49
 */

namespace Zvinger\BaseClasses\app\commands;

use yii\console\Controller;
use Zvinger\BaseClasses\app\helpers\gii\ModelsGeneratorActions;

class ZvingerVendorController extends Controller
{
    public function actionUpdateModels()
    {
        ModelsGeneratorActions::generateUserModels();
    }
}