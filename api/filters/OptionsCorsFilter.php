<?php
namespace Zvinger\BaseClasses\api\filters;

use Yii;
use yii\filters\Cors;

class OptionsCorsFilter extends Cors
{
    public function beforeAction($action)
    {
        parent::beforeAction($action);
        if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            Yii::$app->getResponse()->getHeaders()->set('Allow', 'POST GET PUT');
            Yii::$app->end();
        }

        return true;
    }
}