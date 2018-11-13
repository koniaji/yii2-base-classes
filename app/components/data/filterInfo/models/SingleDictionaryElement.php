<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 30.08.18
 * Time: 13:02
 */

namespace Zvinger\BaseClasses\app\components\data\filterInfo\models;


use yii\base\BaseObject;

class SingleDictionaryElement extends BaseObject
{
    public $id;

    public $title;

    public $description;

    public $parentId;

    /**
     * @var self[]
     */
    public $children;
}