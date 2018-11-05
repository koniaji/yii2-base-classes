<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 27.05.18
 * Time: 9:07
 */

namespace Zvinger\BaseClasses\app\modules\fileStorage\builder;

use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use trntv\filekit\filesystem\FilesystemBuilderInterface;

class AwsFlystemBuilder implements FilesystemBuilderInterface
{
    public $key;

    public $secret;

    public $region;

    public $bucket;

    /**
     * @return mixed
     */
    public function build()
    {
        $client = new S3Client([
            'credentials' => [
                'key'    => $this->key,
                'secret' => $this->secret,
            ],
            'region'      => $this->region,
            'version'     => 'latest',
        ]);
        $adapter = new AwsS3Adapter($client, $this->bucket, 'fs');

        return new Filesystem($adapter);
    }
}