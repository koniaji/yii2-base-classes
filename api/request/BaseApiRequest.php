<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 24.04.18
 * Time: 23:10
 */

namespace Zvinger\BaseClasses\api\request;


use Zvinger\BaseClasses\api\misc\BaseUserIncomeApiModel;

abstract class BaseApiRequest extends BaseUserIncomeApiModel
{
    public static function getBaseData()
    {
        return \Yii::$app->request->post();
    }
}