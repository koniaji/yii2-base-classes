<?php
/**
 * Created by PhpStorm.
 * User: amorev
 * Date: 09.01.2019
 * Time: 13:57
 */

namespace Zvinger\BaseClasses\app\modules\fileStorage\controllers;


use yii\web\Controller;

class FileController extends BaseVendorFileStorageModuleController
{
    public function actionGetFile($id)
    {
        return \Yii::$app->response->sendContentAsFile(file_get_contents($this->module->storage->getFile($id)->getFullUrl()), 'name.png', ['inline' => true]);
    }
}
