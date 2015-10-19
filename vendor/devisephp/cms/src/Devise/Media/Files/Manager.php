<?php namespace Devise\Media\Files;

use Devise\Media\Categories\CategoryPaths;
use Devise\Media\Images\Images;
use Devise\Media\MediaPaths;
use Devise\Media\Helpers\Caption;

/**
 * Class Manager
 * @package Devise\Media\Files
 */
class Manager
{
    /**
     * @var Filesystem
     */
    protected $Filesystem;

    /**
     * @var CategoryPaths
     */
    protected $CategoryPaths;

    /**
     * @var Image
     */
    protected $Image;

    /**
     * Construct a new File manager
     *
     * @param Filesystem $Filesystem
     * @param CategoryPaths $CategoryPaths
     * @param Image $Image
     * @param Caption $Caption
     */
    public function __construct(Filesystem $Filesystem, CategoryPaths $CategoryPaths, MediaPaths $MediaPaths, Images $Image, Caption $Caption, $Config = null)
    {
        $this->Filesystem = $Filesystem;
        $this->CategoryPaths = $CategoryPaths;
        $this->MediaPaths = $MediaPaths;
        $this->Image = $Image;
        $this->Caption = $Caption;
        $this->basepath = public_path() . '/media/';
        $this->Config = $Config ?: \Config::getFacadeRoot();
    }

    /**
     * Saves the uploaded file to the media directory
     *
     * @param $input
     * @return bool
     */
    public function saveUploadedFile($input)
    {
        $file = array_get($input, 'file', null);

        if (is_null($file))
        {
            return false;
        }

        $originalName = $file->getClientOriginalName();
        $localPath = (isset($input['category'])) ? $this->CategoryPaths->fromDot($input['category']) : '';
        $serverPath = $this->CategoryPaths->serverPath($localPath);

        $newName = $this->createFile($file, $serverPath, $originalName);

        if ($this->Image->canMakeThumbnailFromFile($file))
        {
            $thumbnailPath = $this->getThumbnailPath($localPath . '/' . $newName);
            if (! is_dir(dirname($thumbnailPath))) mkdir(dirname($thumbnailPath), 0755, true);
            $this->Image->makeThumbnailImage($serverPath . $newName, $thumbnailPath, $file->getClientMimeType());
        }

        return $localPath . '/' . $newName;
    }

    /**
     * Renames an uploaded file
     *
     * @param  string $filepath
     * @param  string $newpath
     * @return void
     */
    public function renameUploadedFile($filepath, $newpath)
    {
        if($this->Caption->exists($this->basepath . $filepath)){
            $oldCptPath = $this->MediaPaths->imageCaptionPath($this->basepath . $filepath);
            $newCptPath = $this->MediaPaths->imageCaptionPath($this->basepath . $newpath);
            
            $this->Filesystem->rename($oldCptPath, $newCptPath);            
        }

        return $this->Filesystem->rename($this->basepath . $filepath, $this->basepath . $newpath);
    }

    /**
     * Remove uploaded files from the /media directory
     *
     * @param  string $filepath
     * @return void
     */
    public function removeUploadedFile($filepath)
    {
        $this->Filesystem->delete($this->basepath . $filepath);
    }

    /**
     * Change this
     * @param $currentName
     * @return string
     */
    private function getThumbnailPath($currentName)
    {
        return $this->MediaPaths->fileVersionInfo('/media/' . $currentName)->thumbnail;
    }

    /**
     * Checks for file existence and then creates file.. if the file
     * already exists we create a new file (clone)
     *
     * @param  File $file
     * @param  string $serverPath
     * @param  string $originalName
     * @return string
     */
    private function createFile($file, $serverPath, $originalName)
    {
        $newName = $originalName;

        $info = pathinfo($newName);

        $sanity = 0;

        while (file_exists($serverPath . '/' . $newName))
        {
            $dir = $info['dirname'] === '.' ? '' : $info['dirname'];
            $newName = $dir . $info['filename'] . '.copy.' . $info['extension'];

            if ($sanity++ > 5) throw new \Exception("You've got a lot of copies of this file... I'm going to stop trying to make copies...");
        }

        $file->move($serverPath, $newName);

        return $newName;
    }
}