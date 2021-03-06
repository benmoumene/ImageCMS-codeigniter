orders 5SubPageProductOCACest.php<?php
use \OrdersTester;
class SubPageProductOCACest
{
//---------------------------AUTORIZATION--------------------------------------- 
    /**
     * @group aa
     */
    public function Login(OrdersTester $I){
        InitTest::Login($I);
    }    
    
    
     
    
    
    
    
    ///---///---Tests For Category Product in Select------------------------------------------------------------------------------------------------------------------------------------------
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Parent Category on Select Menu.');
        $I->createCategoryProduct(CreateCategoryOrdersPage::$CrtCatName1);
        $I->SearchCategorySelect(CreateCategoryOrdersPage::$CrtCatName1ForSearch);
    } 
    
    
    
    
    
    
    
     /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ChildCategoryFirstLevel (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Child Category Firs Level on Select Menu.');
        $I->createCategoryProduct(CreateCategoryOrdersPage::$CrtCatName2, CreateCategoryOrdersPage::$CrtCatName1ForSearch);
        $I->SearchCategorySelect(CreateCategoryOrdersPage::$CrtCatName2ForSearchOrder);
    }
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ChildCategorySecondLevel(OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Child Category Second Level on Select Menu.');
        $I->createCategoryProduct(CreateCategoryOrdersPage::$CrtCatName3, CreateCategoryOrdersPage::$CrtCatName2ForSearchOrder);
        $I->SearchCategorySelect(CreateCategoryOrdersPage::$CrtCatName3ForSearchOrder);
    }
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ICMS823JiraRegressionBug (OrdersTester\OrdersSteps $I) {
        $I->wantTo('ICMS-823 Jira, Verify Noactive Category Presence on Create Orders Admin Page.');
        $I->createCategoryProduct('Category Regression Jira ICMS-823', NULL);
        $I->amOnPage('/admin/components/run/shop/orders/create');
        $I->wait('1');
        $I->click(\CreateOrderAdminPage::$CrtZMenuCategoryDefolt);
        $I->fillField(\CreateOrderAdminPage::$CrtZMenuCategoryInput, 'Category');
        $I->click(\CreateOrderAdminPage::$CrtZMenuCategorySearchButton);
        $I->see('Category Regression Jira ICMS-823', 'a.chosen-single > span');
    }
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function VerifyCategoryPresenceInSelectMenu (OrdersTester $I){
       $I->wantTo('Compare identity O product categories sElECt menu pages "Create Item" and "Create Order".');
       $I->wantTo('');
       $AllOptions =[]; 
       $I->amOnPage('/admin/components/run/shop/products/create');
       $AllProductOptions = $I->grabTagCount($I, 'select option', 2);
       $MakeVisible1 = "$('select:eq(2)').css({'display':'block'})";
       $I->executeJS($MakeVisible1);
       for($row = 1; $row <= $AllProductOptions; ++$row){
           $AllOptions[$row] = $I->grabTextFrom("//div[@class = 'control-group'][2]//div//select/option[$row]");
       }
       
       
       $I->amOnPage('/admin/components/run/shop/orders/create');
       $OrderCategoriesLength = $I->grabTagCount($I, 'select option');
       
       $MakeVisible2 = "$('select:eq(0)').css({'display':'block'})";
       $I->executeJS($MakeVisible2);
       
       for($row = 1; $row <= $OrderCategoriesLength; ++$row){
           $AllOrderOptions[$row] = $I->grabTextFrom("//select[1]/option[$row]");
       }
       foreach ($AllOptions as $key => $AllOptionNow) {
           $I->assertEquals(str_replace([' ','-'],'',$AllOptionNow), str_replace([' ','-'],'',$AllOrderOptions[$key]));
       }
    }
    
    
    
    
    
    
    
    
    
    
    
    ///---///----Tests For Name Product----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    
    
    
    
    

    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductNemaLatinSmallParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Product Latin Small Name in Parent Category on Select Menu.');
        $I->createProduct($nameProduct = 'abcdefghijklmnopqrstuvwxyz',
                                        $nameVariantProduct = NULL ,
                                        $priceProduct = '1',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName1ForSearch, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductNameLatSmallAutocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Product Name Presence.');
        $I->SearchNameProductaAutocomplete($typeName = "abcdefghijklmnopqrstuvwxyz");
    }
    
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductNemaLatinBigParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Product Latin Big Name in Parent Category on Select Menu.');
        $I->createProduct($nameProduct = 'MNOPQRSTUVWXYZABCDEFGHIJKL',
                                        $nameVariantProduct = NULL ,
                                        $priceProduct = '1',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName1ForSearch, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductNameLatBigAutocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Product Name Presence.');
        $I->SearchNameProductaAutocomplete($typeName = "MNOPQRSTUVWXYZABCDEFGHIJKL");
    }
    
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductNemaCillicSmallParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Product Cirillic Small Name in Parent Category on Select Menu.');
        $I->createProduct($nameProduct = '????????????????????????????????????????????????????????????????????????',
                                        $nameVariantProduct = NULL ,
                                        $priceProduct = '1',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName1ForSearch, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductNameCirilicSmallAutocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Product Name Presence.');
        $I->SearchNameProductaAutocomplete($typeName = "????????????????????????????????????????????????????????????????????????");
    }
    
    
    
    
    
    
    
    
    /**
     * @group aa
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductNemaCillicBigParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Product Cirillic Big Name in Parent Category on Select Menu.');
        $I->createProduct($nameProduct = '????????????????????????????????????????????????????????????????????????',
                                        $nameVariantProduct = NULL ,
                                        $priceProduct = '1',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName1ForSearch, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group aa
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductNameBiigSmallAutocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Product Name Presence.');
        $I->SearchNameProductaAutocomplete($typeName = "????????????????????????????????????????????????????????????????????????");
    }
    
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductNemaNumeralParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Product Numeral Name in Parent Category on Select Menu.');
        $I->createProduct($nameProduct = '1 2 3 4 5 6 7 8 9 0',
                                        $nameVariantProduct = NULL ,
                                        $priceProduct = '1',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName1ForSearch, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductNameNumeralAutocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Product Name Presence.');
        $I->SearchNameProductaAutocomplete($typeName = "1 2 3 4 5 6 7 8 9 0");
    }
    
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductNemaSymbolParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Product Symbol Name in Parent Category on Select Menu.');
        $I->createProduct($nameProduct = "??????????????????????????????><???????????????????>@!?%<&???????????????*???{}[])(^:|",
                                        $nameVariantProduct = NULL ,
                                        $priceProduct = '1',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName1ForSearch, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductNameSymbolAutocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Product Name Presence.');
        $I->SearchNameProductaAutocomplete($typeName = "??????????????????????????????><?????????????");
    }
    
    
    
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function DeleteCeatingProducts(OrdersTester\OrdersSteps $I) {
        $I->DeleteProductInCategory($CategoryWithProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
    }
    
    
    
    
    
   
    ///---///----Tests For Variant Product--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductVariantMinParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Variant Min in First Child Category on Select Menu.');
        $I->createProduct($nameProduct = '?????????? ?? ?????????????????????? ?????????????????? ????????????????',
                                        $nameVariantProduct = 'x' ,
                                        $priceProduct = '1',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName2ForSearchCategory);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName2ForSearchOrder, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductVarianMinAutocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Variant Name Presence.');
        $I->SearchVariantProductAutocomplete($productName = '?????????? ?? ?????????????????????? ?????????????????? ????????????????', $variantName = 'x'); 
    }
    
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductVariantLatinSmallParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Variant Latin Small in First Child Category on Select Menu.');
        $I->createProduct($nameProduct = '?????????? ?? ??????.??????.??????. ?? ???????????????? ????????????????',
                                        $nameVariantProduct = 'abcdefghijklmnopqrstuvwxyz',
                                        $priceProduct = '1',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName2ForSearchCategory);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName2ForSearchOrder, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductVarianLatinSmallAutocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Variant Name Presence.');
        $I->SearchVariantProductAutocomplete($productName = '?????????? ?? ??????.??????.??????. ?? ???????????????? ????????????????', $variantName = 'abcdefghijklmnopqrstuvwxyz'); 
    }
    
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductVariantLatinBigParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Variant Latin Big in First Child Category on Select Menu.');
        $I->createProduct($nameProduct = '?????????? ?? ??????.??????.??????. ?? ???????????????? ????????????????',
                                        $nameVariantProduct = 'NOPQRSTUVWXYZABCDEFGHIJKLM',
                                        $priceProduct = '1',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName2ForSearchCategory);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName2ForSearchOrder, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductVarianLatinBigAutocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Variant Name Presence.');
        $I->SearchVariantProductAutocomplete($productName = '?????????? ?? ??????.??????.??????. ?? ???????????????? ????????????????', $variantName = 'NOPQRSTUVWXYZABCDEFGHIJKLM'); 
    }
    
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductVariantCirillicSmallParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Variant Cirillic Small in First Child Category on Select Menu.');
        $I->createProduct($nameProduct = '?????????? ?? ??????.??????.??????. ?? ???????????????? ????????????????',
                                        $nameVariantProduct = '????????????????????????????????????????????????????????????????????????',
                                        $priceProduct = '1',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName2ForSearchCategory);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName2ForSearchOrder, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductVarianCirilicSmallAutocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Variant Name Presence.');
        $I->SearchVariantProductAutocomplete($productName = '?????????? ?? ??????.??????.??????. ?? ???????????????? ????????????????', $variantName = '????????????????????????????????????????????????????????????????????????'); 
    }
    
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductVariantCirilliBigParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Variant Cirillic Big in First Child Category on Select Menu.');
        $I->createProduct($nameProduct = '?????????? ?? ??????.??????.??????. ?? ???????????????? ????????????????',
                                        $nameVariantProduct = '????????????????????????????????????????????????????????????????????????',
                                        $priceProduct = '1',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName2ForSearchCategory);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName2ForSearchOrder, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductVarianCirilicBigAutocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Variant Name Presence.');
        $I->SearchVariantProductAutocomplete($productName = '?????????? ?? ??????.??????.??????. ?? ???????????????? ????????????????', $variantName = '????????????????????????????????????????????????????????????????????????'); 
    }
    
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductVariantNumeralParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Variant Numeral in First Child Category on Select Menu.');
        $I->createProduct($nameProduct = '?????????? ?? ?????????????? ?? ???????????????? ????????????????',
                                        $nameVariantProduct = '1 2 3 4 5 6 7 8 9 0',
                                        $priceProduct = '1',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName2ForSearchCategory);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName2ForSearchOrder, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductVarianNumeralAutocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Variant Name Presence.');
        $I->SearchVariantProductAutocomplete($productName = '?????????? ?? ?????????????? ?? ???????????????? ????????????????', $variantName = '1 2 3 4 5 6 7 8 9 0'); 
    }
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function DeleteProductIn2Category(OrdersTester\OrdersSteps $I) {
       $I->DeleteProductInCategory($CategoryWithProduct = CreateCategoryOrdersPage::$CrtCatName2ForSearchOrder); 
    }




















//    /**
//     * @group x
//     * @guy OrdersTester\OrdersSteps
//     */
//    public function ProductVariantSymbolParentCategory (OrdersTester\OrdersSteps $I) {
//        $I->wantTo('Verify Presence Variant Symbol in First Child Category on Select Menu.');
//        $I->createProduct($nameProduct = '?????????? ?? ???????? ?????????????????? ?? ???????????????? ????????????????',
//                                        $nameVariantProduct = '`!@#$%^&*|}{.,',
//                                        $priceProduct = '1',
//                                        $articleProduct = NULL,
//                                        $amountProduct = NULL,
//                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName2ForSearchCategory);
//          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName2ForSearchOrder, $typeProductName = $nameProduct);
//          $I->AddToBascketSelect();
//          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
//          InitTest::ClearAllCach($I);
//    }
//    /**
//     * @group x
//     * @guy OrdersTester\OrdersSteps
//     */
//    public function SearchProductVarianSymbolAutocomplit (OrdersTester\OrdersSteps $I){
//        $I->SearchVariantProductAutocomplete($productName = '?????????? ?? ???????? ?????????????????? ?? ???????????????? ????????????????', $variantName = '`!@#$%^&*|}{.,'); 
//    }
    
    
    
    
    
    
    
    
    
    
    ///---///----Tests For Price Product-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductPriceMinParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Price Null in Second Child Category on Select Menu.');
        $I->wait('3');
        $I->createProduct($nameProduct = '0??????????0 0??0 0??????????????0 0??????????0',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = '0',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName3ForSearchCategory);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName3ForSearchOrder, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductPriceNullAutocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Price Presence.');
        $I->SearchPriceProductAutocomplete($typeName = '0??????????0 0??0 0??????????????0 0??????????0', $typePrice = '0'); 
    }
    
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SelectNumber1AfterPoint(OrdersTester\OrdersSteps $I) {
        $I->wantTo('Select The Number Of The Menu Price After The Point');
        $I->SelectNumberAfterPoint($numberAfterPoint = 1);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductPricePoint1ParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Price in Second Child Category on Select Menu.');
        $I->createProduct($nameProduct = 'zagibok Pointa',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = '0.1',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName3ForSearchCategory);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName3ForSearchOrder, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductPriceMin1Autocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Price Presence.');
        $I->SearchPriceProductAutocomplete($typeName = 'zagibok Pointa', $typePrice = '0.1'); 
    }
    
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SelectNumber2AfterPoint(OrdersTester\OrdersSteps $I) {
        $I->wantTo('Select The Number Of The Menu Price After The Point');
        $I->SelectNumberAfterPoint($numberAfterPoint = 2);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductPricePoint2ParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Price in Second Child Category on Select Menu.');
        $I->createProduct($nameProduct = 'terpinkod 222Producticus2 ?? 222 ??????????????',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = '0.11',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName3ForSearchCategory);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName3ForSearchOrder, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductPriceMin2Autocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Price Presence.');
        $I->SearchPriceProductAutocomplete($typeName = 'terpinkod 222Producticus2 ?? 222 ??????????????', $typePrice = '0.11'); 
    }
    
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductPricePoint2MaxParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Price in Second Child Category on Select Menu.');
        $I->createProduct($nameProduct = 'PRDmax 2654 ??????????????????????',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = '0.99',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName3ForSearchCategory);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName3ForSearchOrder, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductPriceMin3Autocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Price Presence.');
        $I->SearchPriceProductAutocomplete($typeName = 'PRDmax 2654 ??????????????????????', $typePrice = '0.99'); 
    }
    
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SelectNumber11AfterPoint(OrdersTester\OrdersSteps $I) {
        $I->wantTo('Select The Number Of The Menu Price After The Point');
        $I->SelectNumberAfterPoint($numberAfterPoint = 1);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductPrice1AndPointParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Price in Second Child Category on Select Menu.');
        $I->amOnPage('/admin/components/run/shop/orders/create');
        $I->createProduct($nameProduct = 'WwWTOvaR55',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = '9878.3',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName3ForSearchCategory);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName3ForSearchOrder, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductPricemin4Autocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Price Presence.');
        $I->SearchPriceProductAutocomplete($typeName = 'WwWTOvaR55', $typePrice = '9878.3'); 
    }
    
    
    
    
    
    
       
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SelectNumber111AfterPoint(OrdersTester\OrdersSteps $I) {
        $I->wantTo('Select The Number Of The Menu Price After The Point');
        $I->SelectNumberAfterPoint($numberAfterPoint = 2);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function  ProductPrice2AndPointParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Price in Second Child Category on Select Menu.');
        $I->createProduct($nameProduct = 'OlOlO integer33 1 ?? 1 beFore',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = '6543127.86',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName3ForSearchCategory);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName3ForSearchOrder, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductPricemin5Autocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Price Presence.');
        $I->SearchPriceProductAutocomplete($typeName = 'OlOlO integer33 1 ?? 1 beFore', $typePrice = '6543127.86'); 
    }
    
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductPrice3AndPointParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Price in Second Child Category on Select Menu.');
        $I->createProduct($nameProduct = 'DESTROY 22second values after point22',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = '99.99',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName3ForSearchCategory);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName3ForSearchOrder, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductPricemin6Autocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Price Presence.');
        $I->SearchPriceProductAutocomplete($typeName = 'DESTROY 22second values after point22', $typePrice = '99.99'); 
    }

    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductPrice4AndPointParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Price in Second Child Category on Select Menu.');
        $I->createProduct($nameProduct = 'Picachu null after null point null',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = '99.00',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName3ForSearchCategory);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName3ForSearchOrder, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductPricemin7Autocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Price Presence.');
        $I->SearchPriceProductAutocomplete($typeName = 'Picachu null after null point null', $typePrice = '99.00'); 
    }
    
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductPrice5AndPointParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Price in Second Child Category on Select Menu.');
        $I->createProduct($nameProduct = 'SoSiskA maximuzik price ?? ????????????',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = CreateProductsOrdersPage::$CrtPrdPriceMax,//10000000000000
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName3ForSearchCategory);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName3ForSearchOrder, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductPricemin8Autocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Price Presence.');
        $I->SearchPriceProductAutocomplete($typeName = 'SoSiskA maximuzik price ?? ????????????', $typePrice = '10000000000000'); 
    }
    
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SelectNumber113AfterPoint(OrdersTester\OrdersSteps $I) {
        $I->wantTo('Select The Number Of The Menu Price After The Point');
        $I->SelectNumberAfterPoint($numberAfterPoint = 2);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductPrice6AndPointParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Price in Second Child Category on Select Menu.');
        $I->createProduct($nameProduct = 'Moonnigth ???????? null max ??????????',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = '10000000000000.00',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName3ForSearchCategory);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName3ForSearchOrder, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = $priceProduct, $totalPrice = $priceProduct, $Check = $priceProduct);
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductPricemin9Autocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Price Presence.');
        $I->SearchPriceProductAutocomplete($typeName = 'Moonnigth ???????? null max ??????????', $typePrice = '10000000000000.00'); 
    }
    
    

    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SelectNumber114AfterPoint(OrdersTester\OrdersSteps $I) {
        $I->wantTo('Select The Number Of The Menu Price After The Point');
        $I->SelectNumberAfterPoint($numberAfterPoint = 5);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductPrice7AndPointParentCategory (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Price in Second Child Category on Select Menu.');
        $I->createProduct($nameProduct = 'JJJJJ ???????? ???? ???????? after pointsesis',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = '1000000000000000.99999',
                                        $articleProduct = NULL,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName3ForSearchCategory);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName3ForSearchOrder, $typeProductName = $nameProduct);
          $I->AddToBascketSelect();
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = '1000000000000000.00', $totalPrice = '1000000000000000.00', $Check = '1000000000000000.00');
          InitTest::ClearAllCach($I);
    }
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function SearchProductPricemin10Autocomplit (OrdersTester\OrdersSteps $I){
        $I->wantTo('Verify Check Price Presence.');
        $I->SearchPriceProductAutocomplete($typeName = 'JJJJJ ???????? ???? ???????? after pointsesis', $typePrice = '1000000000000000.00'); 
    }

    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function DeletePriceProductInCategory (OrdersTester\OrdersSteps $I){
        $I->DeleteProductInCategory($CategoryWithProduct = CreateCategoryOrdersPage::$CrtCatName3ForSearchOrder);
    }
    
    
    
    
    

    
    
    ///---///----Tests For Article Product-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    
    
    
    
    
    

    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductArticleMin (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Article on Autocomplete.');
        $I->createProduct($nameProduct = '?????????? ?? ??????.??????????????????.',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = 1,
                                        $articleProduct = 'r2d2',
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
        $I->SearchArticleProductAutocomplete($articleProduct = 'r2d2');  
        InitTest::ClearAllCach($I);
    }
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductArticleLatinSmall (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Article on Autocomplete.');
        $I->createProduct($nameProduct = '?????????? ?? Lat Small ??????????????????.',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = 1,
                                        $articleProduct = 'opqrstuvwxyabcdefglmnzhijk',
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
        $I->SearchArticleProductAutocomplete($articleProduct = 'opqrstuvwxyabcdefglmnzhijk');  
        InitTest::ClearAllCach($I);
    }
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductArticleLatinBig (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Article on Autocomplete.');
        $I->createProduct($nameProduct = '?????????? ?? Lat Big ??????????????????',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = 1,
                                        $articleProduct = 'LMNOPQRSTUABCDEFGHIJKVWXYZ',
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
        $I->SearchArticleProductAutocomplete($articleProduct = 'LMNOPQRSTUABCDEFGHIJKVWXYZ');  
        InitTest::ClearAllCach($I);
    }
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductArticleCirilicSmall (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Article on Autocomplete.');
        $I->createProduct($nameProduct = '?????????? ?? Cirilic Small  ??????????????????',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = 1,
                                        $articleProduct = '????????????????????????????????????????????????????????????????????????',
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
        $I->SearchArticleProductAutocomplete($articleProduct = '????????????????????????????????????????????????????????????????????????');  
        InitTest::ClearAllCach($I);
    }
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductArticleCirilicBig (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Article on Autocomplete.');
        $I->createProduct($nameProduct = '?????????? ?? Cirilic Big  ??????????????????',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = 1,
                                        $articleProduct = '????????????????????????????????????????????????????????????????????????',
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
        $I->SearchArticleProductAutocomplete($articleProduct = '????????????????????????????????????????????????????????????????????????');  
        InitTest::ClearAllCach($I);
    }
    
    
    
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductArticleNumeral (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Article on Autocomplete.');
        $I->createProduct($nameProduct = '?????????? ?? Articl Numer ??????????????????',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = 1,
                                        $articleProduct = '7890123456',
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
        $I->SearchArticleProductAutocomplete($articleProduct = '7890123456');  
        InitTest::ClearAllCach($I);
    }
    
    
    
    
    
    

    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductArticleNumeralSpace (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Article on Autocomplete.');
        $I->createProduct($nameProduct = '?????????? ?? Article Num Space ??????????????????',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = 1,
                                        $articleProduct = '1 2 3 4 5 6 7 8 9 0',
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
        $I->SearchArticleProductAutocomplete($articleProduct = '1 2 3 4 5 6 7 8 9 0');  
        InitTest::ClearAllCach($I);
    }
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductArticleSymbol (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Article on Autocomplete.');
        $I->createProduct($nameProduct = '?????????? ?? ?????????????????????? ?????????????????? ?? ????????????????.',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = 1,
                                        $articleProduct = InitTest::$textSymbols,
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
        $I->SearchArticleProductAutocomplete($articleProduct = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????');  
        InitTest::ClearAllCach($I);
    }
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductArticleSpaceTabBefore(OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Article on Autocomplete.');
        $I->createProduct($nameProduct = '?????????? ?? ???????????????? ?? ?????????? ?????????? ????????????  ?? ????????????????.',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = 1,
                                        $articleProduct = '  ??????????3333',
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
        $I->SearchArticleProductAutocomplete($articleProduct = '??????????3333');  
        InitTest::ClearAllCach($I);
    }
    
    
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductArticlSpaceTabAfter (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Presence Article on Autocomplete.');
        $I->createProduct($nameProduct = '?????????? ?? ???????????????? ?? ?????????? ?????????? ?????????? ?? ????????????????.',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = 1,
                                        $articleProduct = '??????????4444            ',
                                        $amountProduct = NULL,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
        $I->SearchArticleProductAutocomplete($articleProduct = '??????????4444');  
        InitTest::ClearAllCach($I);
    }
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function DeleteArticleProductInCategory (OrdersTester\OrdersSteps $I){
        $I->DeleteProductInCategory($CategoryWithProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
    }













///---///----Tests For Amount Product-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function VerifyFieldAmountInputSymbols(OrdersTester\OrdersSteps $I) {//Amount 09876543432
        $I->wantTo('Verify input invalid values in field Amount".');
        $I->createProduct($nameProduct = 'Amount 09876543432', $nameVariantProduct = NULL, $priceProduct = 1);
        $I->click(\NavigationBarPage::$Orders);
        $I->click(\NavigationBarPage::$OrdersList);
        $I->wait('3');
        $I->click(\OrdersListPage::$ListButtCreateOrder);
        $I->wait('3');
        $I->fillField('#productNameForOrders', 'Amount 09876543432');
        $I->wait('1');
        $I->click('//body/ul[2]/li[1]/a');
        $I->wait('1');
        $I->click(CreateOrderAdminPage::$CrtPButtAddToCart);
        $I->fillField(CreateOrderAdminPage::$CrtPFieldAmount, ' ');
        $I->dontSeeInField(CreateOrderAdminPage::$CrtPFieldAmount, ' ');
        $I->fillField(CreateOrderAdminPage::$CrtPFieldAmount, InitTest::$textSymbols);
        $I->dontSeeInField(CreateOrderAdminPage::$CrtPFieldAmount, InitTest::$textSymbols);
        $I->seeInField(CreateOrderAdminPage::$CrtPFieldAmount, '1234567890.');       
    }
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ICMS1518ProductAmountNull (OrdersTester\OrdersSteps $I) {
         $I->wantTo('Switch The Radio Button Amount Out of stock');
         $I->SelectAmountOutStock($amountOutStockNo = NULL, $amountOutStockYes = 1);
     }
     /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ICMS1518AddBasketProductAmountNull (OrdersTester\OrdersSteps $I) {
        $I->wantTo('ICMS-1518 Task From Jira.');
        $I->createProduct($nameProduct = 'ICMS-1518 ???????????????? Jira.',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = 1,
                                        $articleProduct = NULL,
                                        $amountProduct = 0,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName1ForSearch, $typeProductName = $nameProduct);
          $I->click(\CreateOrderAdminPage::$CrtPButtAddToCart);
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = '1', $totalPrice = '1', $Check = '1');
          InitTest::ClearAllCach($I);
        
    }
    
    
    
    
    /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function ProductAmountYes (OrdersTester\OrdersSteps $I) {
         $I->wantTo('Switch The Radio Button Amount Out of stock');
         $I->SelectAmountOutStock($amountOutStockNo = 'Check', $amountOutStockYes = NULL);
     }
     /**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function AddBasketProductAmountYes (OrdersTester\OrdersSteps $I) {
        $I->wantTo('Verify Add To Basket Product Whith Zero Amount.');
        $I->createProduct($nameProduct = '???????????????? ?? ?????????????? ???????????????? Yes.',
                                        $nameVariantProduct = NULL,
                                        $priceProduct = 1,
                                        $articleProduct = NULL,
                                        $amountProduct = 0,
                                        $categoryProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
          $I->SearchProductNameSelect($typeCategoryName = CreateCategoryOrdersPage::$CrtCatName1ForSearch, $typeProductName = $nameProduct);
          $I->click(\CreateOrderAdminPage::$CrtPButtAddToCart);
          $I->SearchProductInBascket($name = $nameProduct, $variant = $nameVariantProduct, $Price = '1', $totalPrice = '1', $Check = '1');
          InitTest::ClearAllCach($I);
        
    }
    
    
/**
     * @group a
     * @guy OrdersTester\OrdersSteps
     */
    public function DeleteAmountYesProductInCategory (OrdersTester\OrdersSteps $I){
        $I->DeleteProductInCategory($CategoryWithProduct = CreateCategoryOrdersPage::$CrtCatName1ForSearch);
    }
    

    
    
}

