<?php

namespace template_manager\classes;

require_once realpath(dirname(__FILE__) . '/../../../..') . '/enviroment.php';

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-04-09 at 15:05:25.
 */
class TArchiveTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var TArchive
     */
    protected $object;

    /**
     * 
     * @var string
     */
    protected $dataFolder;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->dataFolder = PUBPATH . 'tests/tests/unit/template_manager/temp/TArchiveTest/';

        // cleaning temporary folder
        \CI::$APP->load->helper('file');
        $tempFolder = $this->dataFolder . 'temp';
        if (file_exists($tempFolder)) {
            delete_files($tempFolder, TRUE);
            mkdir($tempFolder);
        }

        $testArchive = 'some_template.zip';

        $this->objectValid = new TArchive($this->dataFolder . $testArchive);
        //$this->objectNotValid = new TArchive($this->dataFolder . $testArchive . '111');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers template_manager\classes\TArchive::unpack
     * expectedException Exception
     */
    public function testUnpack() {
        $tempFolder = $this->dataFolder . 'temp';
        $res = $this->objectValid->unpack($tempFolder);
        $this->assertTrue($res);
    }

    /**
     * @covers template_manager\classes\TArchive::getZipHandler
     */
    public function testGetZipHandler() {
        $zip = $this->objectValid->getZipHandler();
        $this->assertTrue($zip instanceof \ZipArchive);
    }

    /**
     * @covers template_manager\classes\TArchive::getTemplateName
     */
    public function testGetTemplateName() {
        $result = $this->objectValid->getTemplateName();
        $this->assertTrue(is_string($result));
    }

    /**
     * @covers template_manager\classes\TArchive::getColorSchemes
     */
    public function testGetColorSchemes() {
        $result = $this->objectValid->getColorSchemes();
        $this->assertTrue(is_array($result));
    }

    /**
     * @covers template_manager\classes\TArchive::getComponents
     */
    public function testGetComponents() {
        $result = $this->objectValid->getComponents();
        $this->assertTrue(is_array($result));
    }

}