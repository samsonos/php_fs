<?php
namespace tests;

use samson\fs\FileService;

/**
 * Created by Vitaly Iegorov <egorov@samsonos.com>
 * on 04.08.14 at 16:42
 */
class EventTest extends \PHPUnit_Framework_TestCase
{
    /** Test service initialization */
    public function testInitialize()
    {
        // Create instance
        $fileService = new FileService(__DIR__.'../');

        // Create local file service instance
        if (!class_exists('samson\fs\LocalFileService')) {
            new samson\fs\LocalFileService();
        }

        // Initialize method
        $fileService->init(array(''));

        // Perform test
        $this->assertNotEmpty($fileService, 'File service initialization failed');
    }

    /** Test unreal file service */
    public function testInitializeUnrealFileService()
    {
        // Create instance
        $fileService = new FileService(__DIR__.'../');

        // Set unreal file service class name
        $fileService->fileServiceClassName = 'IDoNotExist';

        // Initialize method
        $result = $fileService->init(array());

        // Perform test
        $this->assertTrue($result, 'File service initialization failed');
    }
}
