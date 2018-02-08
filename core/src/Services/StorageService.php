<?php
namespace EventoOriginal\Core\Services;

use Illuminate\Support\Facades\Storage;

class StorageService
{
    /**
     * @param $file
     * @param $remoteFilePath
     * @param null $options
     * @return bool
     */
    public function store($file, $remoteFilePath, $options = null)
    {
        $s3 = Storage::disk('s3');

        return $s3->put($remoteFilePath, file_get_contents($file), $options);
    }

    /**
     * @param $filePath
     * @return bool
     */
    public function remotePictureExist($filePath)
    {
        $exists = Storage::disk('s3')->exists($filePath);

        return $exists;
    }

    /**
     * @param $filePath
     * @return null|string
     */
    public function getPictureUrl($filePath)
    {
        if ($this->remotePictureExist($filePath)) {
            $imageUrl = Storage::disk('s3')->url($filePath);
            return $imageUrl;
        }

        return null;
    }

    /**
     * Save a picture with public status
     * @param $image
     * @param $remotePath
     * @param $extension
     * @return mixed
     */
    public function savePicture($image, $remotePath, $extension)
    {
        $fileName = strtolower($remotePath . '/' . uniqid() . '.' . $extension);
        $this->store($image, $fileName, 'public');

        return $this->getPictureUrl($fileName);
    }
}
