<?php
/**
 * Created by PhpStorm.
 * User: egorov
 * Date: 03.12.2014
 * Time: 20:26
 */
namespace samson\fs;

use samson\core\CompressableService;

/**
 * Abstract IFileService implementation
 * with higher level functions implemented
 * @package samson\fs
 */
abstract class AbstractFileService extends CompressableService implements IFileSystem
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
        'audio/mpeg'	=> 'mp3'
    );

    /**
     * Override default service function to meet correct return type requirements.
     * @see \samson\core\Service::getInstance()
     *
     * @param string $className Class name for getting service instance
     * @return IFileSystem File service instance
     */
    public static function & getInstance($className)
    {
        return parent::getInstance($className);
    }

    /**
     * Get file mime type in current file system
     * @param $filePath string Path to file
     * @return string|bool false if mime not found, otherwise file mime type
     */
    public function mime($filePath)
    {
        // Get file extension from path
        $extension = $this->exists($filePath);

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
     * Copy file to selected location
     * @param string $filePath      Source path or file path
     * @param string $newPath       New path or file path
     * @return string|boolean False if failed otherwise path to copied file
     */
    public function copyPath($filePath, $newPath)
    {
        // Check if source file exists
        if ($this->exists($filePath)) {
            // If we copy to other path
            if ($filePath != $newPath) {
                // Build new relative path
                $newRelativePath = $this->relativePath($newPath, basename($newPath));

                // If this is directory
                if ($this->isDir($filePath)) {
                    // Read directory
                    foreach ($this->dir($filePath) as $file) {
                        // Get file name
                        $fileName = basename($file);
                        // Read source file and write to new location
                        $this->write(
                            $this->read($file, $fileName),
                            $fileName,
                            $newRelativePath
                        );
                    }
                } else { // Read source file and write to new location
                    // Get file name
                    $fileName = basename($newPath);
                    $this->write(
                        $this->read($filePath, $fileName),
                        $fileName,
                        $newRelativePath
                    );
                }

                // Return copied file path
                return $newPath;

            } else { // Paths matched nothing must happen
                return false;
            }
        } else {
            return e(
                'Cannot copy file[##] to [##] - Source file does not exists',
                E_SAMSON_CORE_ERROR,
                array($filePath, $newPath)
            );
        }
    }

    /**
     * Move file to selected location
     * @param string $filePath      Source path or file path
     * @param string $newPath       New path or file path
     * @return string|false False if failed otherwise path to moved file
     */
    public function movePath($filePath, $newPath)
    {
        // Copy path to a new location
        if (($this->copyPath($filePath, $newPath)) !== false) {
            // Remove current path
            $this->delete($filePath);

            return $newPath;
        } else { // Copy failed
            return false;
        }
    }
}
