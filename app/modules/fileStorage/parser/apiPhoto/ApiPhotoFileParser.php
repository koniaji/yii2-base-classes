<?php

namespace Zvinger\BaseClasses\app\modules\fileStorage\parser\apiPhoto;


use Zvinger\BaseClasses\app\modules\fileStorage\components\storage\VendorFileStorageComponent;
use Zvinger\BaseClasses\app\modules\fileStorage\parser\interfaces\FileParserInterface;
use Zvinger\BaseClasses\app\modules\fileStorage\parser\models\ApiPhotoModel;
use Zvinger\BaseClasses\app\modules\fileStorage\VendorFileStorageModule;

class ApiPhotoFileParser implements FileParserInterface
{
    /**
     * @var VendorFileStorageModule
     */
    private $fileStorageComponent;

    public function __construct(VendorFileStorageModule $fileStorageComponent)
    {
        $this->fileStorageComponent = $fileStorageComponent;
    }

    /**
     * @param $fileId
     * @return mixed
     * @throws \Exception
     */
    public function parseFile($fileId)
    {
        $model = new ApiPhotoModel();
        $model->photoId = $fileId;
        $element = $this->fileStorageComponent->storage->getFile($fileId);
        $fullUrl = $this->fileStorageComponent->glide->createSignedUrl([
            'fileStorage/glide',
            'path' => $element->fileStorageElement->path,
        ], true);
//        $fullUrl = FULL_BASE_URL . '/fileStorage/glide?path=' . $element->fileStorageElement->path;
        $model->photo75 =
        $model->photo130 =
        $model->photo640 =
        $model->photo860 =
        $model->photo1280 =
        $model->photo2560 = $fullUrl;

        return $model;
    }
}