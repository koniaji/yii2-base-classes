<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 26.05.18
 * Time: 22:51
 */

namespace Zvinger\BaseClasses\app\modules\fileStorage\parser\interfaces;


interface FileParserInterface
{
    /**
     * @param $fileId
     * @return mixed
     */
    public function parseFile($fileId);
}