<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 20.08.18
 * Time: 18:48
 */

namespace Zvinger\BaseClasses\app\components\data\filterInfo\models;

use Zvinger\BaseClasses\app\components\data\filterInfo\VendorFilterInfoService;

class SimpleValueElement extends BaseFilterElement
{
    protected static $type = self::TEXT;

    public function beforeSet($key, VendorFilterInfoService $service)
    {

    }


}