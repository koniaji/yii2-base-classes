<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 28.12.17
 * Time: 15:33
 */

namespace Zvinger\BaseClasses\app\modules\fileStorage\components\storage;

use yii\base\BaseObject;
use yii\di\ServiceLocator;
use yii\web\UploadedFile;
use Zvinger\BaseClasses\app\exceptions\model\ModelValidateException;
use Zvinger\BaseClasses\app\modules\fileStorage\components\storage\models\FileStorageSaveResult;
use Zvinger\BaseClasses\app\modules\fileStorage\components\storage\models\SavedFileModel;
use Zvinger\BaseClasses\app\modules\fileStorage\components\storage\storages\base\BaseVendorStorage;
use Zvinger\BaseClasses\app\modules\fileStorage\models\fileStorageElement\FileStorageElementObject;

class VendorFileStorageComponent extends BaseObject
{
    public $storageComponents;

    /**
     * @var ServiceLocator
     */
    private $_storage_locator;

    public function init()
    {
        $this->_storage_locator = new ServiceLocator([
            'components' => $this->storageComponents,
        ]);
        parent::init();
    }


    /**
     * @param $type
     * @return object|BaseVendorStorage
     * @throws \yii\base\InvalidConfigException
     */
    public function getStorage($type)
    {
        /** @var BaseVendorStorage $obj */
        $obj = $this->_storage_locator->get($type);
        $obj->type = $type;

        return $obj;
    }

    /**
     * @param string $fileKey
     * @param string $type
     * @return SavedFileModel
     * @throws \yii\base\InvalidConfigException
     * @throws ModelValidateException
     */
    public function uploadPostFile($fileKey = 'file', $type = 'default')
    {
        $file = UploadedFile::getInstanceByName($fileKey);
        $storage = $this->getStorage($type);
        $result = $storage->save($file);

        return $this->saveFile($result);
    }

    /**
     * @param FileStorageSaveResult $fileStorageSaveResult
     * @return SavedFileModel
     * @throws ModelValidateException
     */
    private function saveFile(FileStorageSaveResult $fileStorageSaveResult)
    {
        $object = new FileStorageElementObject([
            'component' => $fileStorageSaveResult->component,
            'path'      => $fileStorageSaveResult->path,
        ]);
        if (!$object->save()) {
            throw new ModelValidateException($object);
        }

        $result = new SavedFileModel([
            'component'          => $fileStorageSaveResult->component,
            'fileStorageElement' => $object,
            'fileStorageComponent' => $this
        ]);

        return $result;
    }

    /**
     * @param $file_id
     * @return SavedFileModel
     * @throws \yii\base\InvalidConfigException
     */
    public function getFile($file_id)
    {
        $object = FileStorageElementObject::findOne($file_id);
        if (empty($object)) {
            return NULL;
        }

        $model = new SavedFileModel();
        $model->fileStorageElement = $object;
        $model->component = $this->getStorage($object->component);

        return $model;
    }
}