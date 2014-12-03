<?php
namespace samson\fs;

/**
 * Generic file system adapter interface for writing/reading
 * data to a particular file system.
 *
 * @package samson\upload
 */
interface IFileSystem
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
     * @param $filePath string Full path to file
     * @param $filename string File name
     * @return string File data
     */
    public function read($filePath, $filename = null);

    /**
     * Delete file from current file system
     * @param $filename string File for deleting
     * @return mixed
     */
    public function delete($filename);

    /**
     * Get file extension in current file system
     * @param $filePath string Path
     * @return string|bool false if extension not found, otherwise file extension
     */
    public function extension($filePath);

    /**
     * Define if $filePath is directory
     * @param string $filePath Path
     * @return boolean Is $path a directory or not
     */
    public function isDir($filePath);

    /**
     * Get recursive $path listing collection
     * @param string    $path       Path for listing contents
     * @param array     $extensions Collection of file extensions to filter
     * @param int       $maxLevel   Maximum nesting level
     * @param int       $level      Current nesting level of recursion
     * @param array     $restrict   Collection of restricted paths
     * @return array $path recursive directory listing
     */
    public function dir($path, $extensions = null, $maxLevel = null, $level = 0, $restrict = array('.git','.svn','.hg', '.settings'));
}
