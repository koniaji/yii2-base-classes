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
        $this->fillApiPhotoModel($model, $element);

        //url: FULL_BASE_URL . '/fileStorage/glide?path=' . $element->fileStorageElement->path;

        return $model;
    }

    private function fillApiPhotoModel(ApiPhotoModel &$model, SavedFileModel $element)
    {
        $pattern = '/photo\d+/';

        $modelVars = get_object_vars($model);
        foreach ($modelVars as $name => $value) {
            if(preg_match($pattern, $name)) {
                $width = preg_replace('/[^\d]/', '', $name);

                $model->$name = $this->fileStorageComponent->glide->createSignedUrl([
                    'fileStorage/glide',
                    'path' => $element->fileStorageElement->path,
                    'w' => $width
                ], true);
            }
        }
    }
}
