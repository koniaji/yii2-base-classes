<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 24.04.18
 * Time: 23:10
 */

namespace Zvinger\BaseClasses\api\request;


use Zvinger\BaseClasses\api\misc\BaseUserIncomeApiModel;

/**
 * Class BaseApiRequest
 * @package Zvinger\BaseClasses\api\request
 * @SWG\Definition()
 */
abstract class BaseApiRequest extends BaseUserIncomeApiModel
{
    public static function getBaseData()
    {
        return \Yii::$app->request->post();
    }

    /**
     * Дополнительная информация, которая не ложится в основную модель
     * @var mixed
     * @SWG\Property()
     */
    private $miscModelInformation;

    /**
     * @return mixed
     */
    public function getMiscModelInformation()
    {
        return $this->miscModelInformation;
    }

    /**
     * @param mixed $miscModelInformation
     */
    public function setMiscModelInformation($miscModelInformation): void
    {
        $this->miscModelInformation = $miscModelInformation;
    }
}