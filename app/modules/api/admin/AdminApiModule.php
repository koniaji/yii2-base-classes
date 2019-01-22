<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 20.12.17
 * Time: 19:18
 */

namespace Zvinger\BaseClasses\app\modules\api\admin;

use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use Zvinger\BaseClasses\api\controllers\ApiDocsSwaggerController;
use Zvinger\BaseClasses\app\modules\api\ApiModule;

class AdminApiModule extends ApiModule
{

    public function init()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        \Yii::$app->user->enableSession = FALSE;

        $docsScanPaths[] = $this->basePath;
        foreach ($this->modules as $id => $module) {
            $docsScanPaths[] = $this->getModule($id)->basePath;
        }
        $this->controllerMap = [
            'docs'    => [
                'class'     => ApiDocsSwaggerController::class,
                'scanPaths' => $docsScanPaths,
            ],
        ];

        parent::init();
    }
}
