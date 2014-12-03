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
     * Copy file to selected location
     * @param string $filePath      Path to file
     * @param string $filename      File name
     * @param string $uploadDir     Relative path to file
     * @return bool|string False if failed otherwise path to copied file
     */
    public function duplicate($filePath, $filename, $uploadDir)
    {
        // Build new path
        $newPath = $uploadDir.'/'.$filename;

        // Check if source file exists
        if ($this->exists($filePath)) {
            // If this file is not already exists
            if ($filePath != $newPath) {
                // Read source file and write to new location
                $this->write($this->read($filePath, $filename), $newPath);

                // Return copied file path
                return $newPath;

            } else { // Paths matched nothing must happen
                return false;
            }
        } else {
            return e('Cannot copy file[##] to [##] - Source file does not exists',
                E_SAMSON_CORE_ERROR,
                array($filePath, $newPath)
            );
        }
    }

    /**
     * Move file to selected location
     * @param string $filePath      Path to file
     * @param string $filename      File name
     * @param string $uploadDir     Relative path to file
     * @return bool|string False if failed otherwise path to moved file
     */
    public function move($filePath, $filename, $uploadDir)
    {
        // Build new path
        $newPath = $uploadDir.'/'.$filename;

        // Check if source file exists
        if ($this->exists($filePath)) {
            // If this file is not already exists
            if ($filePath != $newPath) {
                // Copy file to a new location
                $this->duplicate($filePath, $filename, $uploadDir);

                // Remove current file
                $this->delete($filePath);

                // Return moved file path
                return $newPath;

            } else { // Paths matched - nothing must happen
                return false;
            }
        } else { // Source file does not exists - signal error
          return e('Cannot move file[##] to [##] - Source file does not exists',
              E_SAMSON_CORE_ERROR,
              array($filePath, $newPath)
          );
        }
    }

    /**
     * Get recursive $path listing collection
     * @param string $path Path for listing contents
     * @param array $extensions Collection of file extensions to filter
     * @param int $maxLevel Maximum nesting level
     * @param int $level Current nesting level of recursion
     * @param array $restrict Collection of restricted paths
     * @return array $path recursive directory listing
     */
    public function dir(
        $path,
        $extensions = null,
        $maxLevel = null,
        $level = 0,
        $restrict = array('.git', '.svn', '.hg', '.settings')
    ) {
        return array();
    }
}
