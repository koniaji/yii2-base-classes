<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 21.12.17
 * Time: 10:16
 */

namespace Zvinger\BaseClasses\app\modules\api\base\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use Zvinger\BaseClasses\app\modules\api\base\BaseApiModule;

/**
 * @SWG\Swagger(
 *     basePath="/api/base/",
 *     produces={"application/json"},
 *     consumes={"application/json"},
 *     @SWG\Info(version="1.0", title="Basical API"),
 * )
 */
class DocsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        $basePath = BaseApiModule::getInstance()->getBasePath();

        return [
            'docs'        => [
                'class'   => 'yii2mod\swagger\SwaggerUIRenderer',
                'restUrl' => Url::to(['docs/json-schema']),
            ],
            'json-schema' => [
                'class'   => 'yii2mod\swagger\OpenAPIRenderer',
                // Тhe list of directories that contains the swagger annotations.
                'scanDir' => [
                    Yii::getAlias($basePath . '/controllers'),
//                    Yii::getAlias($basePath . '/models'),
                    Yii::getAlias($basePath . '/responses'),
                ],
            ],
            'error'       => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}