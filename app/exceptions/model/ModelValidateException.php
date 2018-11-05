<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 21.12.17
 * Time: 13:03
 */

namespace Zvinger\BaseClasses\app\exceptions\model;

use Zvinger\BaseClasses\app\helpers\error\ErrorMessageHelper;
use Throwable;
use yii\base\Exception;
use yii\base\Model;

class ModelValidateException extends Exception
{
    public function __construct(Model $model, string $message = "", int $code = 0, Throwable $previous = NULL)
    {
        $message = new ErrorMessageHelper($model);

        parent::__construct($message, $code, $previous);
    }
}