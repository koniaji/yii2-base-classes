<?php

namespace Zvinger\BaseClasses\app\modules\fileStorage\actions;


use Symfony\Component\HttpFoundation\Request;
use trntv\glide\actions\GlideAction;

class FSGlideAction extends GlideAction
{
    private $_componentInstance;

    /**
     * @var callable
     */
    private $_componentGetter;

    public function getComponent()
    {
        if (empty($this->_componentInstance)) {
            if (!empty($this->_componentGetter)) {
                $componentGetter = $this->_componentGetter;
                $this->_componentInstance = $componentGetter();
            } else {
                $this->_componentInstance = parent::getComponent();
            }
        }

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

}