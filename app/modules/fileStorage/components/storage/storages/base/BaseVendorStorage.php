<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 28.12.17
 * Time: 15:47
 */

namespace Zvinger\BaseClasses\app\modules\fileStorage\components\storage\storages\base;

use yii\base\BaseObject;
use yii\web\UploadedFile;
use Zvinger\BaseClasses\app\modules\fileStorage\components\storage\models\FileStorageSaveResult;

abstract class BaseVendorStorage extends BaseObject
{
    public $type;

    /**
     * @param UploadedFile $file
     * @return FileStorageSaveResult
     */
    public function save(UploadedFile $file)
    {
        $result = $this->saveFile($file);
        $result->component = $this->type;

        return $result;
    }

    /**
     * @param UploadedFile $file
     * @return FileStorageSaveResult
     */
    abstract protected function saveFile(UploadedFile $file): FileStorageSaveResult;

    public function getBaseUrl()
    {
        return NULL;
    }

    public function deleteFile($path)
    {
        return true;
    }
}