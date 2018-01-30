<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 28.12.17
 * Time: 17:08
 */

namespace Zvinger\BaseClasses\app\modules\fileStorage\components\storage\models;

use yii\base\BaseObject;
use Zvinger\BaseClasses\app\modules\fileStorage\components\storage\storages\base\BaseVendorStorage;
use Zvinger\BaseClasses\app\modules\fileStorage\models\fileStorageElement\FileStorageElementObject;

class SavedFileModel extends BaseObject
{
    /** @var FileStorageElementObject */
    public $fileStorageElement;

    /** @var BaseVendorStorage */
    public $component;

    public function getFullUrl()
    {
        $fullBase = $baseUrl = $this->component->getBaseUrl();
        if (!empty($baseUrl)) {
            $fullBase = $baseUrl . DIRECTORY_SEPARATOR;
        }

        return $fullBase . $this->fileStorageElement->path;
    }
}