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
class FileSystemController extends \samson\core\CompressableExternalService implements IAdapter
{
    /** @var string Module identifier */
    protected $id = 'fs';

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
        // TODO: Implement write() method.
    }

    /**
     * Check existing current file in current file system
     * @param $filename string Filename
     * @return boolean File exists or not
     */
    public function exists($filename)
    {
        // TODO: Implement exists() method.
    }

    /**
     * Read the file from current file system
     * @param $filePath string Path to file
     * @param $filename string
     * @return mixed
     */
    public function read($filePath, $filename)
    {
        // TODO: Implement read() method.
    }

    /**
     * Delete file from current file system
     * @param $filename string File for deleting
     * @return mixed
     */
    public function delete($filename)
    {
        // TODO: Implement delete() method.
    }

    /**
     * Write a file to selected location
     * @param $filePath string Path to file
     * @param $filename string
     * @param $uploadDir string
     * @return mixed
     */
    public function copy($filePath, $filename, $uploadDir)
    {
        // TODO: Implement copy() method.
    }
}
