<?php
namespace tests;

use samson\fs\FileService;

/**
 * Created by Vitaly Iegorov <egorov@samsonos.com>
 * on 04.08.14 at 16:42
 */
class EventTest extends \PHPUnit_Framework_TestCase
{
    /** @var \samson\fs\FileService Pointer to file service */
    public $fileService;

    /** Tests init */
    public function setUp()
    {
        // Get instance using services factory as error will signal other way
        $this->fileService = \samson\core\Service::getInstance('samson\fs\FileService');

        // Set real file service class name
        $this->fileService->fileServiceClassName = 'samson\fs\LocalFileService';

        // Initialize service
        $this->fileService->init(array());

        // Disable default error output
        \samson\core\Error::$OUTPUT = false;
    }

    /** Test unreal file service */
    public function testInitializeUnrealFileService()
    {
        // Set unreal file service class name
        $this->fileService->fileServiceClassName = 'IDoNotExist';

        // Initialize service
        $result = $this->fileService->init(array());

        // Perform test
        $this->assertFalse($result, 'File service initialization not failed as expected');
    }

    /** Test reading */
    public function testRead()
    {
        // Read current file data
        $data = $this->fileService->read(__FILE__);

        // Compare current file with data readed
        $this->assertStringEqualsFile(__FILE__, $data, 'File service read failed');
    }

    /** Test file service writing and reading */
    public function testWriteRead()
    {
        // Create temporary file
        $path = tempnam(sys_get_temp_dir(), 'test');

        // Write data to temporary file
        $this->fileService->write('123', $path);

        // Read data from file
        $data = $this->fileService->read($path);

        // Perform test
        $this->assertEquals('123', $data, 'File service writing failed');
    }

    /** Test file service deleting */
    public function testDelete()
    {
        // Create temporary file
        $path = tempnam(sys_get_temp_dir(), 'test');

        // Delete temporary file
        $this->fileService->delete($path);

        // Perform test
        $this->assertFileNotExists($path, 'File service deleting failed');
    }

    /** Test file service existing */
    public function testExists()
    {
        // Create temporary file
        $path = tempnam(sys_get_temp_dir(), 'test');

        // Write data to temporary file
        $exists = $this->fileService->exists($path);

        // Perform test
        $this->assertEquals(true, $exists, 'File service exists failed');
    }

    /** Test relative path building */
    public function testRelativePath()
    {
        // Create temporary file
        $path = tempnam(sys_get_temp_dir(), 'test');
        $fileName = basename($path);

        // Create test dir
        $testDir = sys_get_temp_dir().'/testDir/';
        mkdir($testDir, 0777);

        $testDirRelative = $this->fileService->relativePath($testDir, $fileName, sys_get_temp_dir());
        $this->assertEquals('testDir/', $testDirRelative, 'Directory relative path building failed');

        $testDirRelative = $this->fileService->relativePath($testDir, $fileName);
        $this->assertEquals('testDir/', $testDirRelative, 'Directory relative path building without basePath failed');
    }

    /** Test file service copy */
    public function testCopy()
    {
        // Create temporary file
        $path = tempnam(sys_get_temp_dir(), 'test');
        $fileName = basename($path);

        // Create test dir
        $testDir = sys_get_temp_dir().'/testDir/';
        mkdir($testDir, 0777);

        // Move file to a new dir
        $this->fileService->copyPath($path, $testDir.$fileName);

        // Perform test
        $this->assertFileExists($testDir.$fileName, 'File service copy file failed - Copied file not found');

        // Create test dir
        $testDir2 = sys_get_temp_dir().'/testDir2/';
        mkdir($testDir2, 0777);

        // Copy whole dir with new file to a second new dir
        $this->fileService->copyPath($testDir, $testDir2);

        // Perform test
        $this->assertFileExists($testDir2.$fileName, 'File service copy folder dir failed - Copied file not found');

        // Create temporary file
        $path2 = tempnam(sys_get_temp_dir(), 'test');
        $fileName2 = basename($path2);

        // Copy whole dir to a file
        $this->fileService->copyPath($path2, $testDir2);

        // Perform test
        $this->assertFileNotExists($testDir2.$fileName2, 'File service copy file to folder failed - Copied file found');
    }

    /** Test file service move */
    public function testMove()
    {
        // Create temporary file
        $path = tempnam(sys_get_temp_dir(), 'test');
        $fileName = basename($path);

        // Create test dir
        $testDir = sys_get_temp_dir().'/testDir/';
        mkdir($testDir, 0777);

        // Move file to a new dir
        $this->fileService->movePath($path, $testDir.$fileName);

        // Perform test
        $this->assertFileExists($testDir.$fileName, 'File service move file failed - Moved file not found');
        $this->assertFileNotExists($path, 'File service move file failed - Source file not deleted');
    }

    /** Test file service extension method */
    public function testExtension()
    {
        // Move file to a new dir
        $extension = $this->fileService->extension(__FILE__);

        // Perform test
        $this->assertEquals('php', $extension, 'File service extension method failed - Extension is not correct');
    }

    /** Test file service mime method */
    public function testMime()
    {
        // Move file to a new dir
        $extension = $this->fileService->mime(__FILE__);

        // Perform test
        $this->assertEquals('text/x-c++', $extension, 'File service mime type method failed - Mime type is not correct');
    }
}
