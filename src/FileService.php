<?php
/**
 * Created by PhpStorm.
 * User: onysko
 * Date: 19.11.2014
 * Time: 19:04
 */
namespace samson\fs;

/**
 * File system module controller
 * @package samson\fs
 */
class FileService extends AbstractFileService
{
    /** @var string Module identifier */
    protected $id = 'fs';

    /** @var string Configurable file service class name */
    public $fileServiceClassName = 'samson\fs\LocalFileService';

    /** @var \samson\fs\IFileSystem Pointer to file system adapter */
    protected $fileService;

    /**
     * Initialize module
     * @param array $params Collection of module parameters
     * @return bool True if module successfully initialized
     */
    public function init(array $params = array())
    {
        // If defined file service is not supported
        if (!class_exists($this->fileServiceClassName)) {
            // Signal error
            return e(
                'Cannot initialize file system adapter[##], class is not found',
                E_SAMSON_CORE_ERROR,
                $this->fileServiceClassName
            );
        } else { // Get service instance by
            $this->fileService = AbstractFileService::getInstance($this->fileServiceClassName);
        }

        // Call parent initialization
        return parent::init($params);
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
     * @param $filePath string Full path to file
     * @param $filename string File name
     * @return string File data
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
     * Get file extension in current file system
     * @param $filePath string Path
     * @return string|bool false if extension not found, otherwise file extension
     */
    public function extension($filePath)
    {
        return $this->fileService->extension($filePath);
    }

    /**
     * Define if $filePath is directory
     * @param string $filePath Path
     * @return boolean Is $path a directory or not
     */
    public function isDir($filePath)
    {
        return $this->fileService->isDir($filePath);
    }

    /**
     * Get recursive $path listing collection
     * @param string $path Path for listing contents
     * @param array $extensions Collection of file extensions to filter
     * @param int $maxLevel Maximum nesting level
     * @param int $level Current nesting level of recursion
     * @param array $restrict Collection of restricted paths
     * @param array     $result   Collection of restricted paths
     * @return array $path recursive directory listing
     */
    public function dir(
        $path,
        $extensions = null,
        $maxLevel = null,
        $level = 0,
        $restrict = array('.git', '.svn', '.hg', '.settings'),
        & $result = array()
    ) {
        return $this->fileService->dir($path, $extensions, $maxLevel, $level, $restrict, $result);
    }
}
