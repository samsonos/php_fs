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
     * @param string $data Data to be written
     * @param string $filename File name
     * @param string $uploadDir Relative file path
     * @return string|boolean Relative path to created file, false if there were errors
     */
    public function write($data, $filename = '', $uploadDir = '');

    /**
     * Check existing current file in current file system
     * @param string $filename string Filename
     * @return boolean File exists or not
     */
    public function exists($filename);

    /**
     * Read the file from current file system
     * @param $filePath string Full path to file
     * @param string $filename string File name
     * @return string File data
     */
    public function read($filePath, $filename = null);

    /**
     * Delete file from current file system
     * @param string $filename string File for deleting
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
     * Get file mime type in current file system
     * @param $filePath string Path to file
     * @return string|bool false if mime not found, otherwise file mime type
     */
    public function mime($filePath);

    /**
     * Get relative path from $path
     * @param string $fullPath  Full file path
     * @param string $fileName  File name
     * @param string $basePath  Base path, must end WITHOUT '/', if not passed
     *                          $fullPath one level top directory is used.
     * @return string Relative path to file
     */
    public function relativePath($fullPath, $fileName, $basePath = null);

    /**
     * Copy file/folder to selected location.
     * Copy can be performed from file($filePath) to file($newPath),
     * also copy can be performed from folder($filePath) to folder($newPath),
     * currently copying from file($filePath) to folder($newPath) is not supported.
     *
     * @param string $filePath      Source path or file path
     * @param string $newPath       New path or file path
     * @return boolean False if failed otherwise true if file/folder has been copied
     */
    public function copy($filePath, $newPath);

    /**
     * Get recursive $path listing collection
     * @param string    $path       Path for listing contents
     * @param int       $maxLevel   Maximum nesting level
     * @param int       $level      Current nesting level of recursion
     * @param array     $restrict   Collection of restricted paths
     * @param array     $result   Collection of restricted paths
     * @return array    $result     Resulting collection used in recursion
     */
    public function dir(
        $path,
        $maxLevel = null,
        $level = 0,
        $restrict = array(),
        & $result = array()
    );
}
