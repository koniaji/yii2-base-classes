<?php


namespace Zvinger\BaseClasses\app\modules\api\base\controllers;
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 01.12.17
 * Time: 22:48
 */
class DefaultController extends \yii\rest\Controller
{

    public function actionIndex()
    {
        return [
            'working' => TRUE,
        ];
    }
}