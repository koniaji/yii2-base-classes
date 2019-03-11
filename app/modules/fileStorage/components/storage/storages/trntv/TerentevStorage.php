<?php
/**
 * Created by PhpStorm.
 * User: amorev
 * Date: 17.01.2019
 * Time: 14:25
 */

namespace Zvinger\BaseClasses\app\modules\fileStorage\components\storage\storages\trntv;


use trntv\filekit\File;
use trntv\filekit\Storage;
use Yii;
use yii\helpers\FileHelper;

class TerentevStorage extends Storage
{
    public function save(
        $file,
        $preserveFileName = false,
        $overwrite = false,
        $saveFileName = null,
        $config = [],
        $pathPrefix = ''
    ) {
        $pathPrefix = FileHelper::normalizePath($pathPrefix);
        $fileObj = File::create($file);
        $dirIndex = $this->getDirIndex($pathPrefix);
        if ($preserveFileName === false) {
            do {
                $filename = implode(
                    '.',
                    [
                        Yii::$app->security->generateRandomString(),
                        $fileObj->getExtension(),
                    ]
                );
                $path = implode(DIRECTORY_SEPARATOR, [$pathPrefix, $dirIndex, $filename]);
            } while ($this->getFilesystem()->has($path));
        } else {
            if (!$saveFileName) {
                $filename = $fileObj->getPathInfo('filename');
            } else {
                $filename = $saveFileName;
            }
            $path = implode(DIRECTORY_SEPARATOR, [$pathPrefix, $dirIndex, $filename]);

        }

        $this->beforeSave($fileObj->getPath(), $this->getFilesystem());

        $stream = fopen($fileObj->getPath(), 'rb+');

        $config = array_merge(['ContentType' => $fileObj->getMimeType()], $config);
        if ($overwrite) {
            $success = $this->getFilesystem()->putStream($path, $stream, $config);
        } else {
            $success = $this->getFilesystem()->writeStream($path, $stream, $config);
        }

        if (is_resource($stream)) {
            fclose($stream);
        }

        if ($success) {
            $this->afterSave($path, $this->getFilesystem());

            return $path;
        }

        return false;
    }
}
