<?php

namespace Zvinger\BaseClasses\app\modules\fileStorage;

use yii\helpers\ArrayHelper;
use Zvinger\BaseClasses\app\modules\fileStorage\components\storage\storages\trntv\TerentevFileStorage;
use Zvinger\BaseClasses\app\modules\fileStorage\components\storage\storages\url\UrlFileStorage;
use Zvinger\BaseClasses\app\modules\fileStorage\components\storage\VendorFileStorageComponent;
use Zvinger\BaseClasses\app\modules\fileStorage\parser\apiPhoto\ApiPhotoFileParser;
use Zvinger\BaseClasses\app\modules\fileStorage\parser\interfaces\FileParserInterface;

/**
 * fileStorage module definition class
 * @property VendorFileStorageComponent storage
 * @property \trntv\glide\components\Glide glide
 */
class VendorFileStorageModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'Zvinger\BaseClasses\app\modules\fileStorage\controllers';

    /**
     * @var bool|array
     */
    public $componentsSettings = FALSE;

    public $defaultStorage = 'default';

    public $glideConfig;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (empty($this->glideConfig)) {
            $this->glideConfig = [
                'class'        => 'trntv\glide\components\Glide',
                'sourcePath'   => '@webroot/storage/source/default',
                'cachePath'    => '@webroot/storage/cache/default',
                'urlManager'   => 'urlManager',
                'maxImageSize' => env('GLIDE_MAX_IMAGE_SIZE'),
                'signKey'      => env('GLIDE_SIGN_KEY'),
            ];
        }
        if (empty($this->components)) {
            $defaultComponentsSettings = [
                'default' => [
                    'class'             => TerentevFileStorage::class,
                    'componentSettings' => [
                        'class'      => '\trntv\filekit\Storage',
                        'baseUrl'    => FULL_BASE_URL . '/storage/source/default',
                        'filesystem' => [
                            'class' => '\Zvinger\BaseClasses\app\modules\fileStorage\builder\LocalFlysystemBuilder',
                            'path'  => '@webroot/storage/source/default',
                        ],
                    ],
                ],
                'url'     => [
                    'class' => UrlFileStorage::class,
                ],
            ];
            if ($this->componentsSettings === FALSE) {
                $this->componentsSettings = $defaultComponentsSettings;
            } else {
                $this->componentsSettings = ArrayHelper::merge($defaultComponentsSettings, $this->componentsSettings);
            }
            if ($this->defaultStorage) {
                if (!empty($this->componentsSettings[$this->defaultStorage])) {
                    $this->componentsSettings['default'] = $this->componentsSettings[$this->defaultStorage];
                }
            }
            $this->components = [
                'storage' => [
                    'class'             => VendorFileStorageComponent::class,
                    'storageComponents' => $this->componentsSettings,
                ],
                'glide'   => $this->glideConfig,
            ];
        }
    }

    public function parseFileElement($fileElementId, FileParserInterface $parserClass)
    {
        return $parserClass->parseFile($fileElementId);
    }

    /**
     * @param $fileElementId
     * @throws \yii\base\InvalidConfigException
     */
    public function parseApiPhoto($fileElementId)
    {
        return $this->parseFileElement(
            $fileElementId,
            \Yii::createObject(ApiPhotoFileParser::class, [$this])
        );
    }
}
