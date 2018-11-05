<?php

namespace Zvinger\BaseClasses\app\modules\fileStorage\controllers;

use yii\web\Controller;

/**
 * Default controller for the `fileStorage` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return 1;
    }
}
