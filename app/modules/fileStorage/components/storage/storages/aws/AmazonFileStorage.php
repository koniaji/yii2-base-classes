<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 28.12.17
 * Time: 15:51
 */

namespace Zvinger\BaseClasses\app\modules\fileStorage\components\storage\storages\aws;

use Aws\S3\S3Client;
use trntv\filekit\File;
use trntv\filekit\Storage;
use yii\web\UploadedFile;
use Zvinger\BaseClasses\app\modules\fileStorage\components\storage\models\FileStorageSaveResult;
use Zvinger\BaseClasses\app\modules\fileStorage\components\storage\storages\base\BaseVendorStorage;

class AmazonFileStorage extends BaseVendorStorage
{
    public $key;

    public $secret;

    public $region;

    public $bucket;

    /**
     * @var S3Client
     */
    private $_component;

    public function init()
    {
        parent::init();
        $this->_component = new S3Client([
            'credentials' => [
                'key'    => $this->key,
                'secret' => $this->secret,
            ],
            'region'      => $this->region,
            'version'     => 'latest',
        ]);
    }

    /**
     * @param UploadedFile $file
     * @return FileStorageSaveResult
     * @throws \yii\base\Exception
     */
    protected function saveFile(UploadedFile $file): FileStorageSaveResult
    {
        $file = File::create($file);
        $newFileName = \Yii::$app->security->generateRandomString(16) . '.' . $file->getExtension();
        $folder = '1';
        $fullPath = $folder . DIRECTORY_SEPARATOR . $newFileName;
        $filePath = $this->_component->putObject([
            'Bucket' => $this->bucket,
            'Key'    => $fullPath,
            'Body'   => fopen($file->getPath(), 'r'),
            'ACL'    => 'public-read',
        ]);
        $result = new FileStorageSaveResult();
        $result->path = $fullPath;

        return $result;
    }

    public function getBaseUrl()
    {
        return 'https://s3.' . $this->region . '.amazonaws.com/' . $this->bucket;
    }


}