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

    /** Test file service moving */
    public function testMove()
    {
        // Create temporary file
        $path = tempnam(sys_get_temp_dir(), 'test');

        // Create test dir
        $testDir = sys_get_temp_dir().'/testDir/';
        mkdir($testDir, 0777);

        // Move file to a new dir
        $newPath = $this->fileService->move($path, basename($path), $testDir);

        // Perform test
        $this->assertFileExists($newPath, 'File service move failed - Moved file not found');
        $this->assertFileNotExists($path, 'File service move failed - Original file is not deleted');
    }

    /** Test file service extension method */
    public function testExtension()
    {
        // Move file to a new dir
        $extension = $this->fileService->extension(__FILE__);

        // Perform test
        $this->assertEquals('php', $extension, 'File service extension method failed - Extension is not correct');
    }
}
