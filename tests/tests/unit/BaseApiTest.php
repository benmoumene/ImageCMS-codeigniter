<?php

namespace wishlist\classes;

require_once realpath(dirname(__FILE__) . '/../..') . '/enviroment.php';

doLogin();
/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-06-28 at 11:26:12.
 */
class BaseApiTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var BaseApi
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new BaseApi;
        $_POST = array('wishlist' => 1, 'wishListName');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers wishlist\classes\BaseApi::all
     * @todo   Implement testAll().
     */
    public function testAll() {
        
        $this->assertNotEmpty($this->object->all());
        
        $this->assertInternalType('array', $this->object->all());
        
        $this->assertArrayHasKey('user',  $this->object->all()[0]);
        
        $this->assertArrayHasKey('lists',  $this->object->all()[0]);
        
        $this->assertCount(2, $this->object->all());
    }

    /**
     * @covers wishlist\classes\BaseApi::_addItem
     * @todo   Implement test_addItem().
     * @dataProvider _addItem_provider
     */
    public function test_addItem($var_id) {
        
        $this->assertNotEmpty($this->object->_addItem($var_id));
        
        $this->assertInternalType('string', $this->object->_addItem($var_id));
        
        $this->assertRegExp('/Добавлено/', $this->object->_addItem($var_id));
        
    }
    
     public function _addItem_provider() {
        return array(
            array(1),
            array(2),
            array(3),
            array(4),
            array(5),
            array(6),
            array(7222),
            array(822),
            array(933),
            array(100)          
        );
    }

    /**
     * @covers wishlist\classes\BaseApi::moveItem
     * @todo   Implement testMoveItem().
     */
    public function testMoveItem($var_id, $wish_list_id) {
        
        $this->assertNotEmpty($this->object->moveItem($var_id, $wish_list_id));
        
        $this->assertInternalType('string', $this->object->moveItem($var_id, $wish_list_id));
        
        $this->assertEquals('Операция успешна', $this->object->moveItem($var_id, $wish_list_id));
       
    }
    
     public function moveItem_provider() {
        return array(
            array(1, 10),
            array(2, 11),
            array(3, 1),
            array(4, 123),
            array(5, 111),
            array(6, 1),
            array(7222, 133),
            array(822, 1),
            array(933, 1000),
            array(100, 222)          
        );
    }

    /**
     * @covers wishlist\classes\BaseApi::deleteItem
     * @todo   Implement testDeleteItem().
     */
    public function testDeleteItem($var_id, $wish_list_id) {
        $this->assertNotEmpty($this->object->deleteItem($var_id, $wish_list_id));
        
        $this->assertInternalType('string', $this->object->deleteItem($var_id, $wish_list_id));
        
        $this->assertEquals('Операция успешна', $this->object->deleteItem($var_id, $wish_list_id));
       
        
    }

    /**
     * @covers wishlist\classes\BaseApi::deleteItemByIds
     * @todo   Implement testDeleteItemByIds().
     */
    public function testDeleteItemByIds() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers wishlist\classes\BaseApi::show
     * @todo   Implement testShow().
     */
    public function testShow() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers wishlist\classes\BaseApi::getMostViewedWishLists
     * @todo   Implement testGetMostViewedWishLists().
     */
    public function testGetMostViewedWishLists() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers wishlist\classes\BaseApi::user
     * @todo   Implement testUser().
     */
    public function testUser() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers wishlist\classes\BaseApi::userUpdate
     * @todo   Implement testUserUpdate().
     */
    public function testUserUpdate() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers wishlist\classes\BaseApi::getMostPopularItems
     * @todo   Implement testGetMostPopularItems().
     */
    public function testGetMostPopularItems() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers wishlist\classes\BaseApi::createWishList
     * @todo   Implement testCreateWishList().
     */
    public function testCreateWishList() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers wishlist\classes\BaseApi::deleteWL
     * @todo   Implement testDeleteWL().
     */
    public function testDeleteWL() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers wishlist\classes\BaseApi::updateWL
     * @todo   Implement testUpdateWL().
     */
    public function testUpdateWL() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers wishlist\classes\BaseApi::deleteImage
     * @todo   Implement testDeleteImage().
     */
    public function testDeleteImage() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers wishlist\classes\BaseApi::do_upload
     * @todo   Implement testDo_upload().
     */
    public function testDo_upload() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers wishlist\classes\BaseApi::renderPopup
     * @todo   Implement testRenderPopup().
     */
    public function testRenderPopup() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}
