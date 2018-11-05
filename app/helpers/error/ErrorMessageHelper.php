<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 21.12.17
 * Time: 13:00
 */

namespace Zvinger\BaseClasses\app\helpers\error;

use yii\base\Model;

class ErrorMessageHelper
{
    /**
     * @var Model
     */
    private $_object;

    /**
     * ErrorMessageHelper constructor.
     * @param $_object
     */
    public function __construct(Model $_object)
    {
        $this->_object = $_object;
    }

    public function __toString()
    {
        $summary = $this->_object->getErrorSummary(false);
        $string = implode(";", $summary);

        return $string;
        // TODO: Implement __toString() method.
    }
}