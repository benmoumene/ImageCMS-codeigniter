<?php


/**
 * Basic class for testing payment methods
 * 
 * METHODS:
 * CreatePayment
 * CreateCurrency
 * CheckForAlertPresent
 * CheckInPaymentList
 * DeletePayments
 * GrabAllCreatedCurrenciesOrDelete
 * CreateDelivery
 * CheckInFrontEnd
 * 
 * @author Cray
 * 
 */
class PaymentTestHelper {
    /**
     * Create payment method with specified parameters
     * 
     * @param AcceptanceTester $I   Controller
     * @param string $name          Fill field "Name"
     * @param string $currency      Select "Currency Name"
     * @param string $active        Set Checkbox "Active" on|off
     * @param string $description   Fill field "Description"
     * @param string $paymentsystem Select "Payment system"
     */
    protected function CreatePayment(AcceptanceTester $I, 
            $name, 
            $currency=null, 
            $active=null, 
            $description=null, 
            $paymentsystem=null) {
        
        if(isset($name)){
            $I->amOnPage(PaymentCreatePage::$URL);
            $I->fillField(PaymentCreatePage::$FieldName, $name);
        }
        if(isset($currency)){
            $I->selectOption(PaymentCreatePage::$SelectPaymentSystem, $currency);
        }
        if(isset($active)){
            $Class = $I->grabAttributeFrom('//form/div[1]/div[3]/div[2]/span', 'class');
            
            switch ($active){
                case 'on':
                    if($Class == 'frame_label') { 
                        $I->click(PaymentCreatePage::$CheckboxActive);
                        $I->comment('Checkbox Active on');
                    }
                    break;
                case 'off':
                    if($Class == 'frame_label active') {
                        $I->click(PaymentCreatePage::$CheckboxActive);
                        $I->comment('Checkbox Active off');
                    }
                    break;
            }
        }
        if(isset($description)){
            $I->fillField(PaymentCreatePage::$FieldDescription, $description);
        }
        if(isset($paymentsystem)){
            $I->selectOption(PaymentCreatePage::$SelectPaymentSystem, $paymentsystem);
        }
        $I->click(PaymentCreatePage::$ButtonCreate);
    }
    
    /**
     * Create currency with specified parameters
     * 
     * @param AcceptanceTester  $I
     * @param string            $name
     * @param string            $ISO
     * @param string            $symbol
     * @param string            $rate
     */
    protected function CreateCurrency(AcceptanceTester $I,
            $name='Pounds',
            $ISO='GBP',
            $symbol='??',
            $rate='0.0167'){
        
        $I->amOnPage('/admin/components/run/shop/currencies/create');
            if(isset($name)){
               $I->fillField('//input[@name="Name"]', $name);
            }
            if(isset($ISO)){
               $I->fillField('//input[@name="Code"]', $ISO);
            }
            if(isset($symbol)){
               $I->fillField('//input[@name="Symbol"]', $symbol);
            }
            if(isset($rate)){
               $I->fillField('//input[@name="Rate"]', $rate);
            }
            $I->click('.btn.btn-small.btn-success.formSubmit');
            $this->CheckForAlertPresent($I, 'success');
    }    
    
    /**
     * Checks that selected alert is present in the page
     * 
     * @param AcceptanceTester  $I      controller
     * @param string            $type   success|error|required
     */
    protected function CheckForAlertPresent(AcceptanceTester $I,$type) {
        switch ($type){
            case 'success':
                $I->waitForElementVisible(PaymentListPage::$AlertSuccess);
                $I->waitForElementNotVisible(PaymentListPage::$AlertSuccess);
                break;
            case 'error':
                $I->waitForElementVisible(PaymentListPage::$AlertError);
                $I->waitForElementNotVisible(PaymentListPage::$AlertError);
                break;
            case 'required':
                $I->seeElement(PaymentListPage::$AlertRequiredLabel);
                $I->seeElement(PaymentListPage::$AlertRequiredField);
                break;
            default :
                $I->fail('passed incorrect variable: "$type" to method');
        }
    }
 
    /**
     * Check Paymement
     * 
     * Checks that passed method present at "payment list" page ,
     * then checks the passed parameters and return his row, 
     * or fail test if something wrong
     * 
     * @param AcceptanceTester  $I                  controller
     * @param string            $name               Name of Payment method
     * @param string            $CurrencyName       checks currency name if isset
     * @param string            $CurrencySymbol     checks currency symbol if isset
     * @param bool              $active             checks that method: true - active || false unactive if isset
     * @return int              return row of passed payment
     */
    protected function CheckInPaymentList(AcceptanceTester $I, 
            $name, 
            $CurrencyName = null, 
            $CurrencySymbol = null, 
            $active = null) {
        
        
        isset($name)?$I->comment("I search method $name in list"):$I->fail("name of payment method must be passed");
        $I->amOnPage(PaymentListPage::$URL);
        $I->waitForText("???????????? ???????????????? ????????????", NULL, ".title");
        
        $present    = false;
        $rows       = $I->grabClassCount($I, 'niceCheck')-1;
        
        if ($rows > 0){
            for ($row = 1;$row<=$rows;++$row) { 
                $PaymentMethod = $I->grabTextFrom (PaymentListPage::MethodNameLine($row));
                if ($PaymentMethod == $name){
                    $I->assertEquals($PaymentMethod, $name,"Method $PaymentMethod present in row $row");
                    $present = true;
                    break;
                }
            }
        } else { $I->fail( "Couldn't find $name, there are no created payments" ); }
        if(!$present) { $I->fail("There is no payment $name in list"); }
        
        if(isset($CurrencyName)){
            $grabbedCurrencyName = $I->grabTextFrom(PaymentListPage::CurrencyNameLine($row));
            $I->assertEquals($grabbedCurrencyName, $CurrencyName);
        }
        
        if(isset($CurrencySymbol)){
            $grabbedCurrencySymbol = $I->grabTextFrom(PaymentListPage::CurrencySymbolLine($row));
            $I->assertEquals($grabbedCurrencySymbol, $CurrencySymbol);
            
        }
        
        if(isset($active)){
            $grabbedActiveClass = $I->grabAttributeFrom(PaymentListPage::ActiveLine($row), 'class');
            $active?$I->assertEquals($grabbedActiveClass, 'prod-on_off '):$I->assertEquals($grabbedActiveClass, 'prod-on_off disable_tovar');
        }
        return $row;

    }
    
    /**
     * Delete Payments
     * 
     * Delete all payment methods with names from array, 
     * or all methods with current name if passed string
     * 
     * @param AcceptanceTester $I controller
     * @param array|string $paymethods Names of payment methods witch you want to delete
     */
    protected function DeletePayments(AcceptanceTester $I,$paymethods) {
        $haveSomethingToRemove = false;
        $I->amOnPage(PaymentListPage::$URL);
        $MethodsAmount = $I->grabClassCount($I, 'niceCheck')-1;
        for($row=1;$row<=$MethodsAmount;++$row){
            $MethodName = $I->grabTextFrom(PaymentListPage::MethodNameLine($row));
            if(is_array($paymethods)){
                if(in_array($MethodName, $paymethods)){
                        $I->click(PaymentListPage::CheckboxLine($row));
                        $haveSomethingToRemove = true;
                }
            }elseif(is_string($paymethods)){
                if($paymethods == $MethodName){ 
                    $I->click(PaymentListPage::CheckboxLine($row)); 
                    $haveSomethingToRemove = true;
                }
            }
        }
        if($haveSomethingToRemove){
            $I->click(PaymentListPage::$ButtonDelete);
            $I->waitForElementVisible(PaymentListPage::$DeleteWindowQuestion);
            $I->click(PaymentListPage::$DeleteWindowButtonDelete);
            $I->waitForElementNotVisible(PaymentListPage::$DeleteWindowQuestion);
        }  else { $I->comment('nothing to delete'); }
        return $haveSomethingToRemove;
    }
    
    /**
     * Grab all currencies
     * 
     * Grab all currencies in currencies list page and add them to array
     * If $settedTodeleteName passed olso delete currencies with this name
     * 
     * @param   AcceptanceTester $I
     * @param   array|string $settedTodeleteName set it, to delete one currency or array of currencies
     * @return  array   all creted currencies
     */
    protected function GrabAllCreatedCurrenciesOrDelete(AcceptanceTester $I,$settedTodeleteName=null) {
        $Currencies = [];
        $I->amOnPage(CurrenciesPage::$URL);
        $CurrenciesAmount = $I->grabClassCount($I, 'mainCurrency');
        for($row = 1; $row <= $CurrenciesAmount; ++$row){
            $findedCur = $I->grabTextFrom(CurrenciesPage::CuccencyNameLine($row));
            if(is_string($settedTodeleteName) && $findedCur == $settedTodeleteName 
                    || is_array($settedTodeleteName) && in_array($findedCur, $settedTodeleteName)){
                $I->click("//tr[$row]//td[7]//button");
                $I->waitForElementVisible("div#first .btn.btn-primary");
                $I->wait(1);
                $I->click("div#first .btn.btn-primary");
                $I->waitForElementNotVisible("div#first .btn.btn-primary");
                $I->wait(3);
                $row--;
                $CurrenciesAmount--;
            }else{
                $Currencies[] = $findedCur;
            }
        }
        return $Currencies;
    }
    
    //----------------------Delivery Methods------------------------------------
    /**
     * Create Delivery with specified parrameters
     * 
     * (array) $pay -string only if you transmit one payment method))
     * if you wont to skip some field type null
     * if you want to select several Payment methods transmit array
     * 
     * @param string            $name               Delivery name type off to skip
     * @param sting             $active             Active Checkbox on - enabled| off - disabled
     * @param string            $description        Method description type off to skip
     * @param string            $descriptionprice   Method price description type off to skip
     * @param int|float|string  $price              Delivery price type off to skip
     * @param int|float|string  $freefrom           Delivery free from type off to skip
     * @param string            $message            Delivery sum specified message type off to skip
     * @param string|array      $pay                Pass array or srting - Payment methods "_" - delimiter for few methods
     * @return void
     */
    protected function CreateDelivery(AcceptanceTester $I,
            $name = null, 
            $active = null, 
            $description = null, 
            $descriptionprice = null, 
            $price = null, 
            $freefrom = null, 
            $message = null, 
            $pay = null) {
        
        $I->amOnPage('/admin/components/run/shop/deliverymethods/create');
        
        
        if (isset($name)) {
                $I->fillField(DeliveryCreatePage::$FieldName, $name);
        }
        if (isset($active))  {
                $I->checkOption(DeliveryCreatePage::$CheckboxActive);
        }
        if (isset($description)) {
                $I->fillField(DeliveryCreatePage::$FieldDescription, $description);
        }
        if (isset($descriptionprice)){
                $I->fillField(DeliveryCreatePage::$FieldDescriptionPrice, $descriptionprice);
        }
        if (isset($price)) {
                $I->fillField(DeliveryCreatePage::$FieldPrice, $price);
        }
        if (isset($freefrom)) {
                $I->fillField(DeliveryCreatePage::$FieldFreeFrom, $freefrom);
        }
        if (isset($message))  {
                $I->checkOption(DeliveryCreatePage::$CheckboxPriceSpecified);
                $I->fillField(DeliveryCreatePage::$FieldPriceSpecified, $message);
        }
        if (isset($pay)) {
                foreach ((array)$pay as $value) {
                    $I->click($value);
                }
        }
        $I->click(DeliveryCreatePage::$ButtonCreate);
        $I->wait("3");
    }
    
    //---------------------------FRONTEND---------------------------------------
    /**
     * Checking current parameters in frontend 
     * first time goes "processing order" page by clicking, other times goes to "processing order" page immediately
     * if you want to skip verifying of some parameters type null
     * verify one payment if string or many if array transmitted
     * 
     * @version 1.1
     * 
     * @param object            $I              Controller
     * @param string            $DeliveryName           Delivery name
     * @param string            $description    Description
     * @param float|int|string  $price          Delivery price
     * @param float|int|string  $freefrom       Delivery free from
     * @param string            $message        Delivery sum specified message
     * @param string|array      $pays           Delivery Payment methods, which will included, if passed string : "_" - delimiter for few methods
     * @param string            $selectpay      Pass to select method, confirm the order and verify payment
     * @return void
     */
    protected function CheckInFrontEnd(AcceptanceTester $I,
            $DeliveryName,
            $description=null,
            $price=null,
            $freefrom=null,
            $message=null,
            $pays=null,
            $selectpay=null) {
        
        
        static $WasCalled  = FALSE;
        
        if(!$WasCalled){
            $I->amOnPage('/shop/product/mobilnyi-telefon-sony-xperia-v-lt25i-black');

            /**
             * @var string buy          button "buy"
             * @var string basket       button "into basket"
             * @var string $Attribute1  class of "buy" button
             */
            $buy        = "//div[@class='frame-prices-buy f-s_0']//form/div[3]"; //button "buy"
            $basket     = "//div[@class='frame-prices-buy f-s_0']//form/div[2]"; //button "into basket"
            $Attribute1 = $I->grabAttributeFrom($buy,'class');                   //class of "buy" button
            //$Attribute2 = $I->grabAttributeFrom($basket,'class');              //class of "into basket" button
            $I->wait(5);
            $Attribute1 == 'btn-buy-p btn-buy'?$I->click($buy):$I->click($basket);
            $I->waitForElementVisible("//*[@id='popupCart']");
            $I->wait(3);
            $I->click(".btn-cart.btn-cart-p.f_r");
        } else { 
            $I->amOnPage("/shop/cart"); 
        }
        
        $WasCalled = TRUE;
        $present = FALSE;
        $I->waitForText('???????????????????? ????????????');
        $DeliveriesInProcessingOrderPageAmount = $I->grabClassCount($I, 'name-count');
        
        for ($j=1;$j<=$DeliveriesInProcessingOrderPageAmount;++$j){
            $GrabbedName = $I->grabTextFrom("//div[@class='frame-radio']/div[$j]//span[@class='text-el']");
            
            if ($GrabbedName == $DeliveryName){
                $present = TRUE;
                break;
            }
        }
        $present?$I->assertEquals($DeliveryName, $GrabbedName):$I->fail("Delivery method isn't present in front end");
        
        if ($description){
            $GrabbedDescription = $I->grabAttributeFrom("//div[@class='frame-radio']/div[$j]//span[@class='icon_ask']", 'data-title');
            $I->assertEquals($GrabbedDescription,$description,"description is the same as desired");
        }
        
        if($price){
            $GrabbedPrice = $I->grabTextFrom("//div[@class='frame-radio']/div[$j]/div[@class='help-block']/div[1]");
            $GrabbedPrice = preg_replace('/[^0-9.]*/u', '', $GrabbedPrice);
            $price  = ceil($price);
            $I->assertEquals($GrabbedPrice, $price,"price is the same as desired");
        }
        
        if($freefrom){
            $Grabbedfreefrom = $I->grabTextFrom("//div[@class='frame-radio']/div[$j]/div[@class='help-block']/div[2]");
            $Grabbedfreefrom = preg_replace('/[^0-9.]*/u', '', $Grabbedfreefrom);
            $freefrom = ceil($freefrom);
            $I->assertEquals($Grabbedfreefrom, $freefrom, "price is the same as desired");
         }
         
         if($message){
             $Cmessage = $I->grabTextFrom("//div[@class='frame-radio']/div[$j]/div[@class='help-block']");
             $I->comment($Cmessage);
             $I->assertEquals($Cmessage, $message,"price specified messege is the same as desired");
         }
         
         if($pays){
//            $JQScrollToclick = "$('html,body').animate({scrollTop:$('div.frame-radio>div:nth-child($j)').offset().top});";
            $I->scrollToElement($I, "div[class=\'frame-radio\'] div:nth-child(1) span[class=\'text-el\']");//scroll for click
            $I->wait(5);
            $I->click("//div[@class='frame-radio']/div[$j]//span[@class='text-el']");
            $I->scrollToElement($I, '.frame-payment.p_r');
            
            if ($pays == 'off'){
                $I->waitForText('?????? ???????????????? ????????????', NULL, '//div[@class="frame-form-field"]/div[@class="help-block"]');
                $I->see('?????? ???????????????? ????????????', '//div[@class="frame-form-field"]/div[@class="help-block"]');
            }
            
            else {
                $I->waitForElementVisible("#cuselFrame-paymentMethod");
                $I->click(".cuselText");
                foreach ((array)$pays as $key => $pay) {
                    $GrabbedPay = $I->grabTextFrom("//div[@id='cusel-scroll-paymentMethod']/span[$key+1]");
                    $I->assertEquals($GrabbedPay, $pay);
                }
            }
        }
        if(isset($selectpay)){
            //$JQScrollToclick = "$('html,body').animate({scrollTop:$('div.frame-radio>div:nth-child($j)').offset().top});";
            $I->scrollToElement($I, "div[class=\'frame-radio\'] div:nth-child(1) span[class=\'text-el\']");//scroll for click
            $I->wait(5);
            $I->click("//div[@class='frame-radio']/div[$j]//span[@class='text-el']");
            $I->scrollToElement($I, '.frame-payment.p_r');
            $I->wait(5);
            $I->click("#cuselFrame-paymentMethod");
            //White spaces added to method in "select" 
            //Read text ,trim then verify , if true click
            $I->grabTextFrom("$cssOrXPathOrRegex");
            $I->click(" ".$selectpay." ");
            $I->wait(5);
        }
    }     
}
