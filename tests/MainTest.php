<?php
namespace tests;

/**
 * Created by Vitaly Iegorov <egorov@samsonos.com>
 * on 04.08.14 at 16:42
 */
class MainTest extends \PHPUnit_Framework_TestCase
{
    /** @var \samsonphp\fs\LocalFileService Pointer to file service */
    public $fileService;

    /** Tests init */
    public function setUp()
    {
        // Disable default error output
        \samson\core\Error::$OUTPUT = false;

        // Get instance using services factory as error will signal other way
        $this->fileService = \samson\core\Service::getInstance('samsonphp\fs\FileService');

        // Init with unreal file service
        $this->fileService->fileServiceClassName = 'samsonphp\fs\test';
        $this->fileService->prepare();
        $this->fileService->init();

        // Normal init
        $this->fileService->fileServiceClassName = 'samsonphp\fs\LocalFileService';
        $this->fileService->prepare();
        $this->fileService->init();
    }

    /** Test configuration of inner file service */
    public function testConfigure()
    {
        require(__DIR__.'/TestEntityConfig.php');
        $this->fileService->configure(new TestEntityConfig());

        $this->assertArrayHasKey('testParam', $this->fileService->configuration);
    }

    /** Test isDir */
    public function testIsDir()
    {
        // Read current file data
        $data = $this->fileService->isDir(__FILE__);

        // Compare current file with data read
        $this->assertEquals(false, $data, 'File service read failed');
    }

    /** Test reading */
    public function testRead()
    {
        // Read current file data
        $data = $this->fileService->read(__FILE__);

        // Compare current file with data read
        $this->assertStringEqualsFile(__FILE__, $data, 'File service read failed');
    }

    /** Test file service writing */
    public function testWrite()
    {
        // Create temporary file
        $path = tempnam(sys_get_temp_dir(), 'test');

        // Write data to temporary file
        $this->fileService->write('123', basename($path), sys_get_temp_dir());

        // Perform test
        $this->assertStringEqualsFile($path, '123', 'File service writing failed');
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

        // Check if path exists
        $exists = $this->fileService->exists($path);
        $notExists = $this->fileService->exists($path.'TEST');

        // Perform test
        $this->assertEquals(true, $exists, 'File service exists failed');
        // Perform test
        $this->assertEquals(false, $notExists, 'File service exists failed');
    }

    /** Test relative path building */
    public function testRelativePath()
    {
        // Create temporary file
        $path = tempnam(sys_get_temp_dir(), 'test');
        $fileName = basename($path);

        // Create test dir
        $testDir = sys_get_temp_dir().'/testDir/';
        if (!$this->fileService->exists($testDir)) {
            $this->fileService->mkDir($testDir);
            $this->fileService->mkDir($testDir);
        }

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
        if (!$this->fileService->exists($testDir)) {
            $this->fileService->mkDir($testDir);
        }

        // Try to null source file
        $this->fileService->copyPath($path.'TEST', $testDir.$fileName);

        // Perform test
        $this->assertFileNotExists($testDir.$fileName, 'File service copy file failed - Copied file not found');

        // Move file to a new dir
        $this->fileService->copyPath($path, $testDir.$fileName);

        // Perform test
        $this->assertFileExists($testDir.$fileName, 'File service copy file failed - Copied file not found');

        // Create test dir
        $testDir2 = sys_get_temp_dir().'/testDir2/';
        if (!$this->fileService->exists($testDir2)) {
            $this->fileService->mkDir($testDir2);
        }

        // Copy whole dir with new file to a second new dir
        $this->fileService->copyPath($testDir, $testDir2);

        // Perform test
        $this->assertFileExists($testDir2.$fileName, 'File service copy folder dir failed - Copied file not found');

        // Create temporary file
        $path2 = tempnam(sys_get_temp_dir(), 'test');
        $fileName2 = basename($path2);

        // Copy whole dir to a file
        $this->fileService->copyPath(dirname($path2), $testDir2.$fileName2);

        // Perform test
        $this->assertFileNotExists($testDir2.$fileName2, 'File service copy file to folder failed - Copied file found');
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

    /** Test file service dir method */
    public function testDir()
    {
        // Scan project root dir
        $files = $this->fileService->dir(dirname(dirname(__FILE__)));

        // Perform test
        $this->assertEquals(true, in_array(__FILE__, $files), 'File service dir failed - This file is not found in listing');
    }

    /** Test file service dir method */
    public function testSleep()
    {
        // Scan project root dir
        $attrs = $this->fileService->__sleep();

        var_dump($attrs);

        // Perform test
        $this->assertEquals(false, in_array('fileService', $attrs), 'File service sleep - FileService is found in listing');
    }
}
