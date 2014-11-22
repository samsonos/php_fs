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
        $fs = new FileService(__DIR__.'../');

        // Initialize method
        $fs->init(array());

        // Perform test
        $this->assertNotEmpty($fs, 'File service initialization failed');
    }
}
