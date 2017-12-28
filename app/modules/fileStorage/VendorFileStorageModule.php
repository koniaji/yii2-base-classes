<?php

namespace Zvinger\BaseClasses\app\modules\fileStorage;

use Zvinger\BaseClasses\app\modules\fileStorage\components\storage\storages\trntv\TerentevFileStorage;
use Zvinger\BaseClasses\app\modules\fileStorage\components\storage\VendorFileStorageComponent;

/**
 * fileStorage module definition class
 * @property VendorFileStorageComponent storage
 */
class VendorFileStorageModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'Zvinger\BaseClasses\app\modules\fileStorage\controllers';

    public $componentsSettings = FALSE;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (empty($this->components)) {
            $defaultComponentsSettings = [
                'default' => [
                    'class'             => TerentevFileStorage::class,
                    'componentSettings' => [
                        'class'      => '\trntv\filekit\Storage',
                        'baseUrl'    => '/storage/source/default',
                        'filesystem' => [
                            'class' => '\Zvinger\BaseClasses\app\modules\fileStorage\builder\LocalFlysystemBuilder',
                            'path'  => '@webroot/storage/source/default',
                        ],
                    ],
                ],
            ];
            if ($this->componentsSettings === FALSE) {
                $this->componentsSettings = $defaultComponentsSettings;
            }
            $this->components = [
                'storage' => [
                    'class'             => VendorFileStorageComponent::class,
                    'storageComponents' => $this->componentsSettings,
                ],
            ];
        }
    }

}
