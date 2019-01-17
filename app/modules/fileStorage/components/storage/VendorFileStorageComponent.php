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
use yii\web\BadRequestHttpException;
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

    private $_temp_folder = '/tmp';

    public function init()
    {
        $this->_storage_locator = new ServiceLocator(
            [
                'components' => $this->storageComponents,
            ]
        );
        parent::init();
    }


    /**
     * @param $type
     * @return object|BaseVendorStorage
     * @throws \yii\base\InvalidConfigException
     */
    public function getStorage($type = 'default')
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
     * @throws BadRequestHttpException
     */
    public function uploadPostFile($fileKey = 'file', $type = null, $saveFileName = null)
    {
        $type = $type ?: $this->getDefaultType();
        $file = UploadedFile::getInstanceByName($fileKey);
        if (empty($file)) {
            throw new BadRequestHttpException("File not given");
        }

        return $this->uploadLocalFile($file, $type, $saveFileName);
    }

    /**
     * @param string $filesKey
     * @param null $type
     * @param null $category
     * @return SavedFileModel[]
     * @throws ModelValidateException
     * @throws \yii\base\InvalidConfigException
     */
    public function uploadPostFiles($filesKey = 'file', $type = null, $saveFileName = null)
    {
        $type = $type ?: $this->getDefaultType();
        $files = UploadedFile::getInstancesByName($filesKey);
        $result = [];
        foreach ($files as $file) {
            $result[] = $this->uploadLocalFile($file, $type, $saveFileName);
        }

        return $result;
    }

    private function getDefaultType()
    {
        return env('DEFAULT_STORAGE', 'default');
    }

    /**
     * @param FileStorageSaveResult $fileStorageSaveResult
     * @return SavedFileModel
     * @throws ModelValidateException
     */
    private function saveFile(FileStorageSaveResult $fileStorageSaveResult)
    {
        $object = new FileStorageElementObject(
            [
                'component' => $fileStorageSaveResult->component,
                'path' => $fileStorageSaveResult->path,
                'title' => $fileStorageSaveResult->fileTitle,
            ]
        );
        if (!$object->save()) {
            throw new ModelValidateException($object);
        }

        $result = new SavedFileModel(
            [
                'component' => $fileStorageSaveResult->component,
                'fileStorageElement' => $object,
                'fileStorageComponent' => $this,
            ]
        );

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
            return null;
        }

        $model = new SavedFileModel();
        $model->fileStorageElement = $object;
        $model->component = $this->getStorage($object->component);

        return $model;
    }

    public function deleteFile($file_id)
    {
        $file = $this->getFile($file_id);
        if ($file->component) {
            return $file->component->deleteFile($file->fileStorageElement->path);
        }
    }

    /**
     * @param $file
     * @param $type
     * @return SavedFileModel
     * @throws ModelValidateException
     * @throws \yii\base\InvalidConfigException
     */
    public function uploadLocalFile(UploadedFile $file, $type = 'default', $saveFileName = null): SavedFileModel
    {
        $storage = $this->getStorage($type);
        if ($saveFileName) {
            $file->name = $saveFileName;
        }
        $result = $storage->save($file);

        return $this->saveFile($result);
    }

    /**
     * @param string $fileUrl
     * @param string|null $extension
     * @return SavedFileModel
     * @throws \yii\base\Exception
     */
    public function uploadExternalFile(string $fileUrl, string $extension = null): SavedFileModel
    {
        $extension = $extension ?: 'file';
        $tmpFile = $this->_temp_folder.'/'.\Yii::$app->security->generateRandomString(10).'.'.$extension;
        file_put_contents($tmpFile, fopen($fileUrl, 'r'));

        return $this->uploadLocalFileByPath($tmpFile);
    }

    /**
     * @param $path
     * @param string $type
     * @param null $category
     * @return SavedFileModel
     * @throws ModelValidateException
     * @throws \yii\base\InvalidConfigException
     */
    public function uploadLocalFileByPath($path, $type = 'default', $category = null): SavedFileModel
    {
        $file = new UploadedFile(
            [
                'name' => $path,
                'tempName' => $path,
            ]
        );

        return $this->uploadLocalFile($file, $type, $category);
    }

    /**
     * @param string $temp_folder
     */
    public function setTempFolder(string $temp_folder): void
    {
        $this->_temp_folder = $temp_folder;
    }
}
