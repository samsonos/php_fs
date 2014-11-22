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

    /** Test service initialization */
    public function testInitialize()
    {
        // Create instance
        $this->fileService = new FileService(__DIR__.'../');

        // Create local service instance
        new \samson\fs\LocalFileService(__DIR__.'../');

        // Initialize service
        $this->fileService->init(array(''));

        // Perform test
        $this->assertNotEmpty($this->fileService, 'File service initialization failed');
    }

    /** Test unreal file service */
    public function testInitializeUnrealFileService()
    {
        // Get instance using services factory as error will signal other way
        $this->fileService = \samson\core\Service::getInstance('samson\fs\FileService');

        // Set unreal file service class name
        $this->fileService->fileServiceClassName = 'IDoNotExist';

        // Initialize service
        $result = $this->fileService->init(array());

        // Perform test
        $this->assertFalse($result, 'File service initialization not failed as expected');
    }
}
