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

    /**
     * Read the file from current file system
     * @param $filePath string Path to file
     * @param $filename string
     * @return mixed
     */
    public function read($filePath, $filename);

    /**
     * Write a file to selected location
     * @param $filePath string Path to file
     * @param $filename string
     * @param $uploadDir string
     * @return mixed
     */
    public function copy($filePath, $filename, $uploadDir);

    /**
     * Delete file from current file system
     * @param $filename string File for deleting
     * @return mixed
     */
    public function delete($filename);
}
