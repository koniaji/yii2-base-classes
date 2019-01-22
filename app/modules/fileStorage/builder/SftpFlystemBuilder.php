<?php
/**
 * Created by PhpStorm.
 * User: amorev
 * Date: 17.01.2019
 * Time: 13:27
 */

namespace Zvinger\BaseClasses\app\modules\fileStorage\builder;


use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;
use trntv\filekit\filesystem\FilesystemBuilderInterface;

class SftpFlystemBuilder implements FilesystemBuilderInterface
{
    public $settings;
    /**
     * @return mixed
     */
    public function build()
    {
        $filesystem = new Filesystem(
            new SftpAdapter(
                $this->settings
            )
        );

        return $filesystem;
    }
}
