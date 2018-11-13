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
use Zvinger\BaseClasses\api\controllers\BaseApiController;
use Zvinger\BaseClasses\app\modules\fileStorage\VendorFileStorageModule;

class UploadController extends BaseApiController
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
        return $this->module->storage->uploadPostFile('file', '');
    }

    public function actionFiles()
    {
        return $this->module->storage->uploadPostFiles('files');
    }
}