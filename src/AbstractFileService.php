<?php
/**
 * Created by PhpStorm.
 * User: egorov
 * Date: 03.12.2014
 * Time: 20:26
 */
namespace samson\fs;

/**
 * Abstract IFileService implementation
 * with higher level functions implemented
 * @package samson\fs
 */
abstract class AbstractFileService implements IFileSystem
{
    /** @var array Collection of mime => extension */
    public static $mimes = array
    (
        'text/css' 					=> 'css',
        'application/x-font-woff' 	=> 'woff',
        'application/x-javascript' 	=> 'js',
        'text/html;charset=utf-8'	=>'htm',
        'text/x-component' 		=> 'htc',
        'image/jpeg' 			=> 'jpg',
        'image/pjpeg' 			=> 'jpg',
        'image/png' 			=> 'png',
        'image/x-png' 			=> 'png',
        'image/jpg' 			=> 'jpg',
        'image/gif' 			=> 'gif',
        'text/plain' 			=> 'txt',
        'application/pdf' 		=> 'pdf',
        'application/zip' 		=> 'zip',
        'application/rtf' 		=> 'rtf',
        'application/msword' 	=> 'doc',
        'application/msexcel' 	=> 'xls',
        'application/vnd.ms-excel'  => 'xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        'application/octet-stream' 	=> 'sql',
        'audio/mpeg'	=> 'mp3',
        'text/x-c++'    => 'php',
    );

    /**
     * File service initialization stage
     */
    public function init()
    {
        // Should be overloaded
    }

    /**
     * Get file mime type in current file system
     * @param $filePath string Path to file
     * @return false|integer|string false if mime not found, otherwise file mime type
     */
    public function mime($filePath)
    {
        // Get file extension from path
        $extension = $this->extension($filePath);

        // Search mimes array and return mime for file otherwise false
        return array_search($extension, self::$mimes);
    }

    /**
     * Get relative path from $path
     * @param string $fullPath  Full file path
     * @param string $fileName  File name
     * @param string $basePath  Base path, must end WITHOUT '/', if not passed
     *                          $fullPath one level top directory is used.
     * @return string Relative path to file
     */
    public function relativePath($fullPath, $fileName, $basePath = null)
    {
        // If no basePath is passed consider that we must go ne level up from $fullPath
        $basePath = !isset($basePath) ? dirname($fullPath) : $basePath;

        // Get dir from path and remove file name of it if no dir is present
        return str_replace($basePath.'/', '', str_replace($fileName, '', $fullPath));
    }

    /**
     * Copy folder to selected location.
     * Copy can be performed from file($filePath) to file($newPath),
     * also copy can be performed from folder($filePath) to folder($newPath),
     * currently copying from file($filePath) to folder($newPath) is not supported.
     *
     * @param string $filePath      Source path or file path
     * @param string $newPath       New path or file path
     * @return bool|null False if failed otherwise true if file/folder has been copied
     */
    protected function copyFolder($filePath, $newPath)
    {
        // Read directory
        foreach ($this->dir($filePath) as $file) {
            // Get file name
            $fileName = basename($file);
            // Read source file and write to new location
            $this->write(
                $this->read($file, $fileName),
                $fileName,
                $newPath
            );
        }
    }

    /**
     * Copy file to selected location.
     * Copy can be performed from file($filePath) to file($newPath),
     * also copy can be performed from folder($filePath) to folder($newPath),
     * currently copying from file($filePath) to folder($newPath) is not supported.
     *
     * @param string $filePath      Source path or file path
     * @param string $newPath       New path or file path
     */
    protected function copyFile($filePath, $newPath)
    {
        // Get file name
        $fileName = basename($newPath);

        // Read and write file
        $this->write(
            $this->read($filePath, $fileName),
            $fileName,
            dirname($newPath)
        );
    }

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
    public function copyPath($filePath, $newPath)
    {
        // Check if source file exists
        if ($this->exists($filePath)) {
            // If this is directory
            if ($this->isDir($filePath)) {
                $this->copyFolder($filePath, $newPath);
            } else { // Read source file and write to new location
                $this->copyFile($filePath, $newPath);
            }

            // Return success
            return true;
        } else { // Signal error
            return e(
                'Cannot copy file[##] to [##] - Source file does not exists',
                E_SAMSON_CORE_ERROR,
                array($filePath, $newPath)
            );
        }
    }
}
