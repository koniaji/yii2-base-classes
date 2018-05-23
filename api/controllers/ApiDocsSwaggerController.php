<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 19.04.18
 * Time: 13:42
 */

namespace Zvinger\BaseClasses\api\controllers;


use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class ApiDocsSwaggerController extends Controller
{
    public $scanPaths;

    public $defaultAction = 'docs';

    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        $arr = [];
        foreach ($this->scanPaths as $scanPath) {
            $arr[] = Yii::getAlias($scanPath);
        }

        return [
            'docs'        => [
                'class'   => 'yii2mod\swagger\SwaggerUIRenderer',
                'view'    => '@vendor/zvinger/yii2-base-classes/api/docs/swagger/view.php',
                'restUrl' => Url::to(['docs/json-schema']),
            ],
            'json-schema' => [
                'class'   => 'yii2mod\swagger\OpenAPIRenderer',
                'scanDir' => $arr,
                'cache'   => YII_ENV_DEV ? NULL : 'cache',
            ],
            'error'       => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if ($action->id == 'docs') {
            Yii::$app->response->format = Yii::$app->response::FORMAT_HTML;
        }

        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }
}