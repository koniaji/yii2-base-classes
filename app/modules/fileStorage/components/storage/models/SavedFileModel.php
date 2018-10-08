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
use Zvinger\BaseClasses\app\modules\fileStorage\components\storage\VendorFileStorageComponent;
use Zvinger\BaseClasses\app\modules\fileStorage\models\fileStorageElement\FileStorageElementObject;

class SavedFileModel extends BaseObject
{
    /** @var FileStorageElementObject */
    public $fileStorageElement;

    /** @var BaseVendorStorage */
    public $component;

    /**
     * @var VendorFileStorageComponent
     */
    private $_fileStorageComponent;

    /**
     * @return string
     * @throws \Exception
     */
    public function getFullUrl()
    {
        $fullBase = $baseUrl = $this->getComponent()->getBaseUrl();
        if (!empty($baseUrl) && substr($baseUrl, -1) != '/') {
            $fullBase = $baseUrl . DIRECTORY_SEPARATOR;
        }

        return $fullBase . $this->fileStorageElement->path;
    }

    /**
     * @throws \Exception
     * @return BaseVendorStorage
     */
    private function getComponent()
    {
        if (is_string($this->component)) {
            if (empty($this->_fileStorageComponent)) {
                throw new \Exception("No file storage component set");
            }

            $this->component = $this->_fileStorageComponent->getStorage($this->component);
        }

        return $this->component;
    }

    /**
     * @param mixed $fileStorageComponent
     * @return SavedFileModel
     */
    public function setFileStorageComponent($fileStorageComponent)
    {
        $this->_fileStorageComponent = $fileStorageComponent;

        return $this;
    }
}