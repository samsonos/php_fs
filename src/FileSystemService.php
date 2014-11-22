<?php
/**
 * Created by PhpStorm.
 * User: onysko
 * Date: 19.11.2014
 * Time: 19:04
 */
namespace samson\fs;

use samson\fs\IAdapter;

/**
 * File system module controller
 * @package samson\fs
 */
class FileSystemService extends \samson\core\CompressableService implements IFileSystem
{
    /** @var string File service identifier */
    public $adapterType = 'fs_local';

    /** @var string Module identifier */
    protected $id = 'fs';

    /** @var \samson\fs\IFileSystem Pointer to file system adapter */
    protected $fileService;

    /**
     * Initialize module
     * @param array $params Collection of module parameters
     * @return bool True if module successfully initialized
     */
    public function init(array $params = array())
    {
        // Set pointer to file service service
        $this->fileService = & \samson\core\Module::$instances[$this->adapterType];

        // If defined file service is not supported
        if (!isset($this->fileService)) {
            // Signal error
            return e(
                'Cannot initialize file system adapter[##], class is not found',
                E_SAMSON_CORE_ERROR,
                $this->adapterType
            );
        }

        // Call parent initialization
        parent::init($params);
    }

    /**
     * Write data to a specific relative location
     *
     * @param mixed $data Data to be written
     * @param string $filename File name
     * @param string $uploadDir Relative file path
     * @return string|boolean Relative path to created file, false if there were errors
     */
    public function write($data, $filename = '', $uploadDir = '')
    {
        return $this->fileService->write($data, $filename, $uploadDir);
    }

    /**
     * Check existing current file in current file system
     * @param $filename string Filename
     * @return boolean File exists or not
     */
    public function exists($filename)
    {
        return $this->fileService->exists($filename);
    }

    /**
     * Read the file from current file system
     * @param $filePath string Path to file
     * @param $filename string
     * @return mixed
     */
    public function read($filePath, $filename = null)
    {
        return $this->fileService->read($filePath, $filename);
    }

    /**
     * Delete file from current file system
     * @param $filename string File for deleting
     * @return mixed
     */
    public function delete($filename)
    {
        return $this->fileService->delete($filename);
    }

    /**
     * Write a file to selected location
     * @param $filePath string Path to file
     * @param $filename string
     * @param $uploadDir string
     * @return mixed
     */
    public function move($filePath, $filename, $uploadDir)
    {
        return $this->fileService->copy($filePath, $filename, $uploadDir);
    }
}
