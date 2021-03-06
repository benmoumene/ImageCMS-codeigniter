<?php

use \DeliveryTester;

class DeliveryEditCest {
    protected $loggedin = false;
    protected $CreatedMethods = [];
    public $Name = "ДоставкаРедактирование";

    /**
     * Works after Autorization before all tests
     * @staticvar int $callCount 0 - first time didn't work, 
     *                           >0 - searching current delivery in list 
     * 
     * @var bool $methodCreated true if current method($this->name) finded in list
     *                          if false Create new delivery method for edit      
     *                   
     * @guy DeliveryTester\DeliverySteps
     */
    public function _before(DeliveryTester\DeliverySteps $I) {
//        static $LoggedIn = false;
        $methodCreated = false;
        if ($this->loggedin == true) {
            $I->amOnPage("/admin/components/run/shop/deliverymethods/index");
            $rows = $I->grabClassCount($I, 'niceCheck') - 1;
            for ($row = 1; $row <= $rows; ++$row) {
                $Cmethod = $I->grabTextFrom(DeliveryPage::ListMethodLine($row));
                if ($this->Name == $Cmethod) {
                    $methodCreated = true;
                    $I->click(DeliveryPage::ListMethodLine($row));
                    break;
                }
            }
            if (!$methodCreated) {
                $I->createDelivery($this->Name);
                $methodCreated = true;
            }
            $I->waitForText("Редактирование способа доставки: $this->Name", NULL, ".title");
        }
        $this->CreatedMethods[] = $this->Name;
//        $LoggedIn = true;
//        $this->loggedin = true;
    }

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function authorization(DeliveryTester\DeliverySteps $I) {
        if (InitTest::Login($I)) {
            $I->wait(1);
            $I->amOnPage(DeliveryPage::$URL);
        }
        $this->loggedin = true;
        InitTest::changeTextAditorToNative($I);
    }

//    __________________________________________________________________________FIELD_NAME_TESTS

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function eName250(DeliveryTester\DeliverySteps $I) {
        $name = InitTest::$text250;
        //For deleting
        $this->CreatedMethods[] = $name;

        $I->EditDelivery($name, 'on');
        $I->CheckInList($name);
        $this->Name = $name;
    }

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function eName500(DeliveryTester\DeliverySteps $I) {
        $name = InitTest::$text500;
        //For deleting
        $this->CreatedMethods[] = $name;

        $I->EditDelivery($name);
        $I->CheckInList($name);
        $this->Name = $name;
    }

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function eNameSymbols(DeliveryTester\DeliverySteps $I) {
        $name = InitTest::$textSymbols;
        //For deleting
        $this->CreatedMethods[] = $name;

        $I->EditDelivery($name);
        $I->CheckInList($name);
    }

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function eNameNormal(DeliveryTester\DeliverySteps $I) {
        $name = "ДоставкаРедактирование";
        //For deleting
        $this->CreatedMethods[] = $name;
        $I->EditDelivery($name);
        $I->CheckInList($name);
    }

//    __________________________________________________________________________CHECKBOX_ACTIVE_TESTS

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps     
     */
    public function eActiveCheck(DeliveryTester\DeliverySteps $I) {
        $I->EditDelivery(null, 'on');
        $I->CheckInList($this->Name, 'on');
    }

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function eActiveUnCheck(DeliveryTester\DeliverySteps $I) {
        $I->EditDelivery(null, 'off');
        $I->CheckInList($this->Name, 'off');
    }

//    __________________________________________________________________________FIELD_DESCRIPTION_TESTS

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function eDescriptionDescriptionPrice(DeliveryTester\DeliverySteps $I) {
        $description = $descriptionprice = InitTest::$textSymbols;
        $I->EditDelivery(null, 'on', $description, $descriptionprice);
        $I->waitForText("Редактирование способа доставки: $this->Name", NULL, ".title");
        $I->seeInField(DeliveryEditPage::$FieldDescription, $description);
        $I->seeInField(DeliveryEditPage::$FieldDescriptionPrice, $descriptionprice);
        $I->CheckInFrontEnd($this->Name, $description);
    }

//    __________________________________________________________________________FIELD_PRICE_TESTS

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function ePriceSymbols(DeliveryTester\DeliverySteps $I) {
        $price = InitTest::$textSymbols;
        $I->EditDelivery(null, null, null, null, $price);
        $Nprice = '1234567890';
        $I->CheckInList($this->Name, null, $Nprice);
    }

//______________________________________________________________________________________________________________________++++++++++++++++BUG_HERE
    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function eFreeFromSymbols(DeliveryTester\DeliverySteps $I) {
        $freefrom = InitTest::$textSymbols;
        $I->EditDelivery(null, null, null, null, null, $freefrom);
        $Nfreefrom = '1234567890';
        $I->CheckInList($this->Name, null, null, $Nfreefrom);
    }

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function ePrice15Num(DeliveryTester\DeliverySteps $I) {
        $price = 9999999999.999;
        $I->EditDelivery(null, null, null, null, $price);
        $I->CheckInList($this->Name, NULL, $price);
    }

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function ePrice1Num(DeliveryTester\DeliverySteps $I) {
        $price = 1;
        $I->EditDelivery(null, null, null, null, $price);
        $I->CheckInList($this->Name, null, $price);
    }

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function ePrice10Num(DeliveryTester\DeliverySteps $I) {
        $price = 55555.55555;
        $I->EditDelivery(null, null, null, null, $price);
        $I->CheckInList($this->Name, null, $price);
    }

//    __________________________________________________________________________FIELD_FREE_FROM_TESTS

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function eFreeFrom1Num(DeliveryTester\DeliverySteps $I) {
        $freefrom = 1;
        $I->EditDelivery(null, null, null, null, null, $freefrom);
        $I->CheckInList($this->Name, null, null, $freefrom);
    }

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function eFreeFrom10Num(DeliveryTester\DeliverySteps $I) {
        $freefrom = 55555.55555;
        $I->EditDelivery(null, null, null, null, null, $freefrom);
        $I->CheckInList($this->Name, null, null, $freefrom);
    }

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function eFreeFrom15Num(DeliveryTester\DeliverySteps $I) {
        $freefrom = 9999999999.999;
        $I->EditDelivery(null, null, null, null, null, $freefrom);
        $I->CheckInList($this->Name, null, null, $freefrom);
    }

//    __________________________________________________________________________CHECKBOX_PRICE_SPECIFIED&FIELD_PRICE_SPECIFIED  

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function eCheckPriceSpecified(DeliveryTester\DeliverySteps $I) {
        $class = $I->grabAttributeFrom(DeliveryEditPage::$CheckboxPriceSpecified . '/..', 'class');
        $I->comment($class);
        $class == 'frame_label no_connection active' ? $I->click(DeliveryEditPage::$CheckboxPriceSpecified) : print "";
        $class = $I->grabAttributeFrom(DeliveryEditPage::$CheckboxPriceSpecified . '/..', 'class');
        if ($class == 'frame_label no_connection') {
            $diabledPrice = $I->grabAttributeFrom(DeliveryEditPage::$FieldPrice, 'disabled');
            $diabledFreefrom = $I->grabAttributeFrom(DeliveryEditPage::$FieldFreeFrom, 'disabled');
            $I->assertEquals($diabledPrice, NULL);
            $I->assertEquals($diabledFreefrom, NULL);
        } else
            $I->fail('wrong class of checkbox sum specified');

        $I->click(DeliveryCreatePage::$CheckboxPriceSpecified);
        $class = $I->grabAttributeFrom(DeliveryEditPage::$CheckboxPriceSpecified . '/..', 'class');

        if ($class == 'frame_label no_connection active') {
            $diabledPrice = $I->grabAttributeFrom(DeliveryEditPage::$FieldPrice, 'disabled');
            $diabledFreefrom = $I->grabAttributeFrom(DeliveryEditPage::$FieldFreeFrom, 'disabled');
            $I->assertEquals($diabledPrice, "true");
            $I->assertEquals($diabledFreefrom, "true");
        } else
            $I->fail('wrong class of checkbox sum specified');
    }

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function ePriceSpecified250(DeliveryTester\DeliverySteps $I) {
        $message = InitTest::$text250;
        $I->EditDelivery(null, 'on', null, null, null, null, $message);
        $I->CheckInFrontEnd($this->Name, null, null, null, $message);
    }

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function eFieldPriceSpecified500(DeliveryTester\DeliverySteps $I) {
        $message = InitTest::$text500;
        $I->EditDelivery(null, 'on', null, null, null, null, $message);
        $I->CheckInFrontEnd($this->Name, null, null, null, $message);
    }

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function eFieldPriceSpecifiedSymbols(DeliveryTester\DeliverySteps $I) {
        $message = InitTest::$textSymbols;
        $I->EditDelivery(null, 'on', null, null, null, null, $message);
        $I->CheckInFrontEnd($this->Name, null, null, null, $message);
    }

//    __________________________________________________________________________PAYMENT_METHODS_FIELD

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function eDeliveryPaymentVerify(DeliveryTester\DeliverySteps $I) {
        $pay = $I->GrabAllCreatedPayments();
        $row = 1;

        $this->_before($I);

        foreach ($pay as $Currentpay) {
            $I->comment($Currentpay);
            $CreatePagePay = $I->grabTextFrom(DeliveryEditPage::PaymentMethodLabel($row));
            $I->assertEquals($CreatePagePay, $Currentpay);
            $row++;
        }
    }

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function eDeliveryPaymentEmpty(DeliveryTester\DeliverySteps $I) {
        //$pay = $I->GrabAllCreatedPayments();
        $this->_before($I);
        $I->EditDelivery(null, 'on', null, null, null, null, null, 'off');
        $I->CheckInFrontEnd($this->Name, null, null, null, null, 'off');
    }

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function eDeliveryPaymentAll(DeliveryTester\DeliverySteps $I) {
        $pay = $I->GrabAllCreatedPayments();
        $this->_before($I);
        $I->EditDelivery(null, 'on', null, null, null, null, null, $pay);
        $I->CheckInFrontEnd($this->Name, NULL, null, null, null, $pay);
    }

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function deleteAllCreatedMethods(DeliveryTester\DeliverySteps $I) {
        $I->amOnPage(DeliveryPage::$URL);
        //Deleting
        $I->DeleteDeliveryMethods($this->CreatedMethods);
        unset($this->CreatedMethods);
    }

    /**
     * @group edit
     * @guy DeliveryTester\DeliverySteps
     */
    public function Logout(DeliveryTester\DeliverySteps $I) {
        InitTest::Loguot($I);
        $this->loggedin = false;
    }
}
