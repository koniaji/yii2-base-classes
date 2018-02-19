<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 23.12.17
 * Time: 9:48
 */

namespace Zvinger\BaseClasses\app\components\keyStorage;

use yii\base\BaseObject;
use yii\helpers\Json;
use yii2mod\settings\components\Settings;

class KeyStorageComponentOld extends BaseObject
{
    private $_settingsSection = 'key-storage';

    private $_settingsComponent = 'settings';

    public function get($key, $default = NULL)
    {
        return $this->getSettingsComponent()->get($this->_settingsSection, $key, $default);
    }

    public function set($key, $value)
    {
        if (is_object($value)) {
            $value = (array)$value;
        }

        return $this->getSettingsComponent()->set($this->_settingsSection, $key, $value);
    }

    public function remove($key)
    {
        return $this->getSettingsComponent()->remove($this->_settingsSection, $key);
    }

    private function getSettingsComponent()
    {
        if (!($this->_settingsComponent instanceof Settings)) {
            $this->_settingsComponent = \Yii::$app->get($this->_settingsComponent);
        }

        return $this->_settingsComponent;
    }

    /**
     * @param string $settingsSection
     */
    public function setSettingsSection(string $settingsSection): void
    {
        $this->_settingsSection = $settingsSection;
    }

    /**
     * @param mixed $settingsComponent
     */
    public function setSettingsComponent($settingsComponent): void
    {
        $this->_settingsComponent = $settingsComponent;
    }
}