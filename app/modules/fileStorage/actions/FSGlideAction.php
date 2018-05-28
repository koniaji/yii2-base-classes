<?php

namespace Zvinger\BaseClasses\app\modules\fileStorage\actions;


use Symfony\Component\HttpFoundation\Request;
use trntv\glide\actions\GlideAction;
use Zvinger\BaseClasses\app\modules\fileStorage\components\storage\storages\trntv\TerentevFileStorage;
use Zvinger\BaseClasses\app\modules\fileStorage\VendorFileStorageModule;

class FSGlideAction extends GlideAction
{
    private $_componentInstance;

    /**
     * @var callable
     */
    private $_componentGetter;

    public function getComponent($new = FALSE)
    {
        if (empty($this->_componentInstance) || $new) {
            if (!empty($this->_componentGetter)) {
                $componentGetter = $this->_componentGetter;
                $this->_componentInstance = $componentGetter();
            } else {
                $this->_componentInstance = parent::getComponent();
            }
        }
        $this->_componentInstance->signKey = FALSE;

        return $this->_componentInstance;
    }

    /**
     * @param mixed $componentInstance
     */
    public function setComponentInstance($componentInstance): void
    {
        $this->_componentInstance = $componentInstance;
    }

    /**
     * @param callable $componentGetter
     */
    public function setComponentGetter(callable $componentGetter): void
    {
        $this->_componentGetter = $componentGetter;
    }

    protected function getServer()
    {
        $componentName = \Yii::$app->request->get('component');
        $storage = VendorFileStorageModule::getInstance()->storage->getStorage($componentName);
        if ($storage instanceof TerentevFileStorage) {
            $this->getComponent(TRUE)->setSource($storage->component->getFilesystem());
        }

        return parent::getServer();
    }
}