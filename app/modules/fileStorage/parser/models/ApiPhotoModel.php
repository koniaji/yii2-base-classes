<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 26.05.18
 * Time: 22:52
 */

namespace Zvinger\BaseClasses\app\modules\fileStorage\parser\models;


class ApiPhotoModel
{
    /** @var int */
    public $photoId;

    /** @var string */
    public $photo75;

    /** @var string */
    public $photo130;

    /** @var string */
    public $photo640;

    /** @var string */
    public $photo860;

    /** @var string */
    public $photo1280;

    /** @var string */
    public $photo2560;

    /** @var int */
    public $width;

    /** @var int */
    public $height;
}