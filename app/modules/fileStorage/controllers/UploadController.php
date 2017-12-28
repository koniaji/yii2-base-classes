<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 28.12.17
 * Time: 15:43
 */

namespace Zvinger\BaseClasses\app\modules\fileStorage\controllers;

use yii\rest\Controller;
use yii\web\UploadedFile;
use Zvinger\BaseClasses\app\modules\fileStorage\VendorFileStorageModule;

class UploadController extends Controller
{
    /**
     * @var VendorFileStorageModule
     */
    public $module;

    /**
     * @return \Zvinger\BaseClasses\app\modules\fileStorage\components\storage\models\SavedFileModel
     * @throws \Zvinger\BaseClasses\app\exceptions\model\ModelValidateException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionFile()
    {
        $result = $this->module->storage->uploadPostFile('file');

        return $result;
    }
}