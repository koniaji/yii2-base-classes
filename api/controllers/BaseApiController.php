<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 01.12.17
 * Time: 23:23
 */

namespace Zvinger\BaseClasses\api\controllers;

use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use Zvinger\BaseClasses\api\filters\OptionsCorsFilter;

class BaseApiController extends Controller
{
    public static $currentCorsOptions = [];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $newBehaviors = [];
        $baseOptions = [
            'Origin'                           => ['*'],
            'Access-Control-Allow-Credentials' => TRUE,
            'Access-Control-Request-Method'    => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
            'Access-Control-Allow-Headers'     => ['*'],
            'Access-Control-Request-Headers'   => ['*'],
        ];
        $newBehaviors['corsFilter'] = [
            'class' => OptionsCorsFilter::className(),
            'cors'  => array_merge($baseOptions, static::$currentCorsOptions),
        ];

        return array_merge($newBehaviors, $behaviors);
    }


    /**
     * @param $key
     * @param string $place post or get
     * @return array|mixed
     * @throws BadRequestHttpException
     */
    protected function checkAndGet($key, $place = 'post')
    {
        $request = \Yii::$app->request;
        if ($place == 'post') {
            $result = $request->post($key);
        } elseif ($place == 'get') {
            $result = $request->get($key);
        }
        if (empty($result)) {
            throw new BadRequestHttpException($key . ' is empty');
        }

        return $result;
    }
}