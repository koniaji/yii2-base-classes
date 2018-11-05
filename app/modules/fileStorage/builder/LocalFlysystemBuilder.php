<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 28.12.17
 * Time: 15:56
 */

namespace Zvinger\BaseClasses\app\modules\fileStorage\builder;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use trntv\filekit\filesystem\FilesystemBuilderInterface;

/**
 * Class LocalFlysystemProvider
 * @author Eugene Terentev <eugene@terentev.net>
 */
class LocalFlysystemBuilder implements FilesystemBuilderInterface
{
    public $path;

    public function build()
    {
        $adapter = new Local(\Yii::getAlias($this->path));
        return new Filesystem($adapter);
    }
}
