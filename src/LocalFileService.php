<?php
/**
 * Created by PhpStorm.
 * User: onysko
 * Date: 17.11.2014
 * Time: 14:12
 */

namespace samson\fs;

/**
 * Local file system adapter implementation
 * @package samson\upload
 */
class LocalFileService extends AbstractFileService
{
    /**
     * Write data to a specific relative location
     *
     * @param mixed $data Data to be written
     * @param string $filename File name
     * @param string $uploadDir Relative file path
     * @return string|false Relative path to created file, false if there were errors
     */
    public function write($data, $filename = '', $uploadDir = '')
    {
        // Build path to writing file
        $path = $uploadDir.'/'.$filename;

        // Put file and return true if at least one byte is written
        if (file_put_contents($path, $data) !== false) {
            return $uploadDir.'/';
        } else { // We have failed my lord..
            return false;
        }
    }

    /**
     * Check existing current file in current file system
     * @param $filename string Filename
     * @return boolean File exists or not
     */
    public function exists($filename)
    {
        return file_exists($filename);
    }

    /**
     * Read the file from current file system
     * @param $filePath string Path to file
     * @param $filename string
     * @return string
     */
    public function read($filePath, $filename = null)
    {
        return file_get_contents($filePath);
    }

    /**
     * Delete file from current file system
     * @param $filename string File for deleting
     * @return mixed
     */
    public function delete($filename)
    {
        unlink($filename);
    }

    /**
     * Get file extension in current file system
     * @param $filePath string Path
     * @return string|bool false if extension not found, otherwise file extension
     */
    public function extension($filePath)
    {
        return pathinfo($filePath, PATHINFO_EXTENSION);
    }

    /**
     * Define if $filePath is directory
     * @param string $filePath Path
     * @return boolean Is $path a directory or not
     */
    public function isDir($filePath)
    {
        return is_dir($filePath);
    }

    /**
     * Get recursive $path listing collection
     * @param string $path Path for listing contents
     * @param array $restrict Collection of restricted paths
     * @param array     $result   Collection of restricted paths
     * @return array $path recursive directory listing
     */
    public function dir($path, $restrict = array(), & $result = array())
    {
        // Check if we can read this path
        if (($handle = opendir($path)) !== false) {

            // Fastest reading method
            while (false !== ($entry = readdir($handle))) {
                // Ignore root paths
                if ($entry != '..' && $entry != '.') {
                    // Build full REAL path to entry
                    $fullPath = realpath($path . '/' . $entry);

                    // If this is a file
                    if (!$this->isDir($fullPath)) {
                        $result[] = $fullPath;
                    } elseif (in_array($fullPath, $restrict) === false) {
                        // If this is a folder - go deeper in recursion
                        $this->dir($fullPath, $restrict, $result);
                    }
                }
            }

            // Close reading handle
            closedir($handle);

            // Sort results
            sort($result);
        }

        return $result;
    }
}
