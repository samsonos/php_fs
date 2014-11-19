<?php
namespace samson\fs;

/**
 * Generic file system adapter interface for writing/reading
 * data to a particular file system.
 *
 * @package samson\upload
 */
interface IAdapter
{
    /**
     * Adapter initialization
     * @param mixed $params collection or parameter for initialization of adapter.
     *                      This depends on adapter implementation.
     * @return mixed True if adapter successfully initialized
     */
    public function init($params);

    /**
     * Write data to a specific relative location
     *
     * @param mixed $data Data to be written
     * @param string $filename File name
     * @param string $uploadDir Relative file path
     * @return string|boolean Relative path to created file, false if there were errors
     */
    public function write($data, $filename = '', $uploadDir = '');

    /**
     * Check existing current file in current file system
     * @param $filename string Filename
     * @return boolean File exists or not
     */
    public function exists($filename);

    public function getFile(& $filepath, $filename);
}
