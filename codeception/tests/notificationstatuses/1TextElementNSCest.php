<?php
use \NotificationStatusesTester;
class TextElementNSCest
{
//---------------------------AUTORIZATION---------------------------------------
    /**
     * @group aaa
     */
    public function Login(NotificationStatusesTester $I){
        InitTest::Login($I);
    }
    

//-----------------------VERIFY LINKS BUTTONS-----------------------------------
    
    /**
     * @group a
     */
    public function VerifyWayNotfStatusesList (NotificationStatusesTester $I){
        $I->wantTo('Verify Way on Notification Statuses List Page.');
        $I->click(NavigationBarPage::$Orders);
        $I->click(NavigationBarPage::$NotificationStatuses);   
        $I->seeInCurrentUrl(NotificationStatusesPage::$ListPageURL);
    } 
    /**
     * @group a
     */
    public function VerifyWayNotfStatusesCreate1 (NotificationStatusesTester $I){
        $I->wantTo('Verify Way on Notification Statuses Create and Edit Page.');
        $I->wait('1');
        $I->click('//body/div[1]/div[3]/div/nav/ul/li[2]/a');
        $I->click('//body/div[1]/div[3]/div/nav/ul/li[2]/ul/li[10]/a');
        $I->seeInCurrentUrl('/admin/components/run/shop/notificationstatuses');
        $I->wait('1');
        $I->click('//body/div[1]/div[5]/div/div[3]/section/div[1]/div[2]/div/a');
        $I->seeInCurrentUrl('/admin/components/run/shop/notificationstatuses/create');
    } 
    /**
     * @group a
     */
    public function VerifyWayNotfStatusesCreate2 (NotificationStatusesTester $I){
        $I->wantTo('Verify Way on Notification Statuses Create and Edit Page.');
        $I->amOnPage('/admin/components/run/shop/notificationstatuses/create');
        $I->click('//body/div[1]/div[5]/div/section/div/div[2]/div/a');
        $I->wait('1');
        $I->seeInCurrentUrl('/admin/components/run/shop/notificationstatuses');
        
    } 
    /**
     * @group a
     */
    public function VerifyWayNotfStatusesEdit1 (NotificationStatusesTester $I){
        $I->wantTo('Verify Way on Notification Statuses Create and Edit Page.');
        $I->amOnPage('/admin/components/run/shop/notificationstatuses');
        $I->click('//body/div[1]/div[5]/div/div[3]/section/div[2]/table/tbody/tr[1]/td[3]/a');
        $I->seeInCurrentUrl('/components/run/shop/notificationstatuses/edit');
        $I->click('//body/div[1]/div[5]/div/section/div[1]/div[2]/div/a');
        $I->seeInCurrentUrl('/admin/components/run/shop/notificationstatuses');
    } 
    
    

//-----------------------VERIFY TEXT LIST PAGE----------------------------------
    
    /**
     * @group a
     */
    public function VerifyTextListPage (NotificationStatusesTester $I){
        $I->wantTo('Verify Text on Notification Statuses List Page.');
        $I->amOnPage(NotificationStatusesPage::$ListPageURL);
        $I->see('?????????????? ?????????????????????? ?? ??????????????????', NotificationStatusesPage::$ListTitle );
        $I->see('?????????????? ????????????', NotificationStatusesPage::$ListButtonCreate);
        $I->see('??????????????', NotificationStatusesPage::$ListButtonDelete);
        $I->see('??????????',  NotificationStatusesPage::$ListNameFirstStatuse);
        $I->see('????????????????',  NotificationStatusesPage::$ListNameSecondStatuse);
        $I->see('ID',  NotificationStatusesPage::$ListNameFirstCollum);
        $I->see('??????', NotificationStatusesPage::$ListNameSecondCollum);
        $I->see('??????????????',  NotificationStatusesPage::$ListNameThirdCollum);
    }   
    
    
    
//-----------------------VERIFY TEXT MESSAGE LIST PAGE--------------------------
    
    /**
     * @group a
     */
    public function VerifyTextMessage (NotificationStatusesTester $I){
        $I->wantTo('Verify Text Message at Focus Cursor on Notification Statuses Name.');
        $I->amOnPage(NotificationStatusesPage::$ListPageURL);
        $I->moveMouseOver(NotificationStatusesPage::$ListLinkEditing);
        $I->waitForText('?????????????????????????? ???????????? ??????????????????????');
        $I->see('?????????????????????????? ???????????? ??????????????????????', 'div.tooltip-inner');
        $I->moveMouseOver(NotificationStatusesPage::$ListButtonCreate);
    }

    
    
//-----------------------VERIFY TEXT DELETE WINDOW------------------------------
    
    /**
     * @group a
     */
    public function VerifyTextDeleteWindow (NotificationStatusesTester $I){
        $I->wantTo('Verify Text on Delete Window.');
        $I->amOnPage(NotificationStatusesPage::$ListPageURL);
        $I->click(NotificationStatusesPage::$ListHeaderCheckBox);
        $I->click(NotificationStatusesPage::$ListButtonDelete);
        $I->waitForText('???????????????? ??????????????', '5', NotificationStatusesPage::$DeleteWindowTitle);
        $I->seeElement(NotificationStatusesPage::$DeleteWindow);
        $I->see('???????????????? ??????????????',  NotificationStatusesPage::$DeleteWindowTitle);
        $I->see('?????????????? ?????? ?????????????', NotificationStatusesPage::$DeleteWindowMassege);
        $I->see('??????????????', NotificationStatusesPage::$DeleteWindowButtonDelete);
        $I->see('????????????????', NotificationStatusesPage::$DeleteWindowButtonCancel);
        $I->see('??', NotificationStatusesPage::$DeleteWindowButtonX);   
    }

    
    
//-----------------------VERIFY TEXT CREATING PAGE------------------------------
    
    /**
     * @group a
     */
    public function VerifyTextCreatePage (NotificationStatusesTester $I){
        $I->wantTo('Verify Text on Create Sataus Page.');
        $I->amOnPage(NotificationStatusesPage::$CreatePageUrl);
        $I->see('???????????????? ?????????????? ?????????????????????? ?? ??????????????????', NotificationStatusesPage::$CreationNameTitle);
        $I->see('??????????????????', NotificationStatusesPage::$CreationButtonBack );
        $I->see('??????????????',  NotificationStatusesPage::$CreationButtonCreate);
        $I->see('?????????????? ?? ??????????',  NotificationStatusesPage::$CreationButtonCreateAndGoBack);        
        $I->see('?????????? ????????????????????',  NotificationStatusesPage::$CreationNameBlock);        
        $I->see('????????????????',  NotificationStatusesPage::$CreationNameFild);        
    }

    
    
//-----------------------VERIFY TEXT EDITING PAGE-------------------------------
    
    /**
     * @group a
     */
    public function VerifyTextEditPage (NotificationStatusesTester $I){
        $I->wantTo('Verify Text on Edit Status Page.');
        $I->amOnPage(NotificationStatusesPage::$EditingPageURL);
        $I->see('???????????????????????????? ?????????????? ?????????????????????? ?? ??????????????????',  NotificationStatusesPage::$EditingNameTitle);
        $I->see('??????????????????',  NotificationStatusesPage::$EditingButtonBack);
        $I->see('??????????????????',  NotificationStatusesPage::$EditingButtonSave);
        $I->see('?????????????????? ?? ??????????',  NotificationStatusesPage::$EditingButtonSaveAndGoBack);
        $I->see('???????????? ?????????????? ?????????????????????? ?? ??????????????????',  NotificationStatusesPage::$EditingNameBlock);
        $I->see('????????????????',  NotificationStatusesPage::$EditingNameFild);
    }

    
    
//-------------VERIFY TEXT ALERT MESSAGE CREATING PAGE--------------------------
    
    /**
     * @group a
     */
    public function VerifyTextAlertMessageCreatingPage (NotificationStatusesTester $I){
        $I->wantTo('Verify Alert Message Present on Create Status Page.');
        $I->amOnPage(NotificationStatusesPage::$CreatePageUrl);
        $I->click('??????????????');
        $I->seeElement(NotificationStatusesPage::$CreationAlertMessage);    
    }

    
    
//-----------------------VERIFY TEXT CREATE MESSAGE-----------------------------
    
    /**
     * @group aaa
     */
    public function VerifyTextCreateMessageCreatingPage (NotificationStatusesTester $I){
        $I->wantTo('Verify Message About Creating Status.');
        $I->amOnPage(NotificationStatusesPage::$CreatePageUrl);
        $I->fillField(NotificationStatusesPage::$CreationFildInput,'qwe 123 !@# ??????');
        $I->click(NotificationStatusesPage::$CreationButtonCreate);
        $I->exactlySeeAlert($I, 'success', '???????????? ???????????????? ????????????');
        $I->wait('1');
    }

    
    
//--------------VERIFY TEXT ALERT MESSAGE EDITING PAGE--------------------------
    
    /**
     * @group aaa
     */
    public function VerifyTextAlertMessageEdictingPage (NotificationStatusesTester $I){
        $I->wantTo('Verify Alert Message.');
        $I->amOnPage(NotificationStatusesPage::$ListPageURL);
        $I->wait('1');
        $I->click('????????????????');
        $I->waitForElement(NotificationStatusesPage::$EditingFildInput);
        $I->fillField(NotificationStatusesPage::$EditingFildInput,'');
        $I->click('.btn.btn-small.btn-primary.action_on.formSubmit');
        $I->waitForElement(NotificationStatusesPage::$CreationAlertMessage);
        $I->seeElement(NotificationStatusesPage::$CreationAlertMessage);    
    }

    
    
//-----------------------VERIFY TEXT EDITING MESSAGE----------------------------
    
    /**
     * @group a
     */
     public function VerifyTextEdicttMessageEdictingPage (NotificationStatusesTester $I){
        $I->wantTo('Verify Alert Message Present on Edit Status Page.');
        $I->amOnPage(NotificationStatusesPage::$ListPageURL);
        $I->waitForElement(NotificationStatusesPage::$ListLinkForEditing);
        $I->click(NotificationStatusesPage::$ListLinkForEditing);
        $I->fillField(NotificationStatusesPage::$EditingFildInput,'???????????????????????? 123123123');
        $I->click(NotificationStatusesPage::$EditingButtonSave);
        $I->wait('1');
        $I->exactlySeeAlert($I, 'success', '?????????????????? ??????????????????');
//        $I->see('?????????????????? ??????????????????',NotificationStatusesPage::$EdictingEdictMessage);
        $I->wait('1');
    }

    
    
//------------VERIFY TEXT DELETING MESSAGE LIST PAGE----------------------------
    
    /**
     * @group a
     */
    public function VerifyTextMessageDeletingStatus (NotificationStatusesTester $I){
        $I->wantTo('Verify Message About Deleting Status Present.');
        $I->amOnPage(NotificationStatusesPage::$ListPageURL);
        $I->waitForElement(NotificationStatusesPage::$ListHeaderCheckBox);
        $I->click(NotificationStatusesPage::$ListHeaderCheckBox);
        $I->click(NotificationStatusesPage::$ListCheckBoxFirst);
        $I->click(NotificationStatusesPage::$ListCheckBoxSecond); 
        $I->click(NotificationStatusesPage::$ListButtonDelete); 
        $I->wait(1);
        $I->click(NotificationStatusesPage::$DeleteWindowButtonDelete);
        $I->waitForText('???????????? ????????????');
        InitTest::ClearAllCach($I);      
    }   
    
    
    
}