<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 24.01.18
 * Time: 12:37
 */

namespace Zvinger\BaseClasses\app\modules\fileStorage\components\storage\storages\url;

use yii\web\UploadedFile;
use Zvinger\BaseClasses\app\modules\fileStorage\components\storage\models\FileStorageSaveResult;
use Zvinger\BaseClasses\app\modules\fileStorage\components\storage\storages\base\BaseVendorStorage;

class UrlFileStorage extends BaseVendorStorage
{
    /**
     * @param UploadedFile $file
     * @return FileStorageSaveResult
     */
    protected function saveFile(UploadedFile $file): FileStorageSaveResult
    {
        // TODO: Implement saveFile() method.
    }
}