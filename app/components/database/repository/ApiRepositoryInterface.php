<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 05.05.18
 * Time: 14:43
 */

namespace Zvinger\BaseClasses\app\components\database\repository;


interface ApiRepositoryInterface
{
    /**
     * @return callable|array
     */
    public function getFillModelCallback();

    /**
     * @return callable|array
     */
    public function getFillObjectCallback();
}