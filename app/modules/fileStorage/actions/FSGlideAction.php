<?php

namespace Zvinger\BaseClasses\app\modules\fileStorage\actions;


use Symfony\Component\HttpFoundation\Request;
use trntv\glide\actions\GlideAction;
use yii\base\NotSupportedException;
use yii\db\Exception;
use Zvinger\BaseClasses\app\modules\fileStorage\components\storage\storages\trntv\TerentevFileStorage;
use Zvinger\BaseClasses\app\modules\fileStorage\controllers\GlideController;
use Zvinger\BaseClasses\app\modules\fileStorage\VendorFileStorageModule;

class FSGlideAction extends GlideAction
{
    /**
     * @var GlideController
     */
    public $controller;

    private $_componentInstance;

    /**
     * @var callable
     */
    private $_componentGetter;

    private $_current_component = null;

    public function run($path = null, $id = null)
    {
        $object = null;
        if (!empty($id)) {
            $object = $this->controller->module->storage->getFile($id);
            $this->_current_component = $object->fileStorageElement->component;
            $path = $object->fileStorageElement->path;
        }

        try {
            return parent::run($path);
        } catch (NotSupportedException $e) {
            if ($object) {
                return \Yii::$app->response->redirect($object->getFullUrl());
            }
        }
    }

    public function getComponent($new = false)
    {
        if (empty($this->_componentInstance) || $new) {
            if (!empty($this->_componentGetter)) {
                $componentGetter = $this->_componentGetter;
                $this->_componentInstance = $componentGetter();
            } else {
                $this->_componentInstance = parent::getComponent();
            }
        }
        $this->_componentInstance->signKey = false;

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
        $this->_current_component = $this->_current_component ?? \Yii::$app->request->get('component');
        $storage = VendorFileStorageModule::getInstance()->storage->getStorage($this->_current_component);
        if ($storage instanceof TerentevFileStorage) {
            $this->getComponent(true)->setSource($storage->component->getFilesystem());
        }

        return parent::getServer();
    }
}
