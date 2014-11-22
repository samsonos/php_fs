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

        // Initialize method
        $fileService->init(array(''));

        // Perform test
        $this->assertNotEmpty($fileService, 'File service initialization failed');
    }

    /** Test unexisted file service */
    public function testInitializeUnexistingFileService()
    {
        // Create instance
        $fileService = new FileService(__DIR__.'../');

        // Initialize method
        $fileService->init(array('fileServiceID' => 'SEX'));

        // Perform test
        $this->assertNotEmpty($fileService, 'File service initialization failed');
    }
}
