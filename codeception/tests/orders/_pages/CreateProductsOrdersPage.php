<?php



class CreateProductsOrdersPage



{
    //Creating Order "Create Products 'Defolt' ".
       
       public static $CrtProductPageURL = "/admin/components/run/shop/products/create";
       public static $CrtProductNameProduct = "//table[1]/tbody/tr/td/div/div/div[1]/div[1]/div/input";
       public static $CrtProductNameVariantProduct = "//table/tbody/tr/td[1]/input[2]";
       public static $CrtProductPriceProduct = "//tbody/tr/td/div/div/div[1]/div[4]/table/tbody/tr/td[2]/input";
       public static $CrtProductArticleProduct = "//tbody/tr/td/div/div/div[1]/div[4]/table/tbody/tr/td[4]/input";
       public static $CrtProductAmountProduct = "//table[1]/tbody/tr/td/div/div/div[1]/div[4]/table/tbody/tr[1]/td[5]/input";
       public static $CrtProductCategoryProductSelectField = "//tbody/tr/td/div/div/div[2]/div/div[2]/div/div/a";
       public static $CrtProductCategoryProductSelectInput = "//tbody/tr/td/div/div/div[2]/div/div[2]/div/div/div/div/input";
       public static $CrtProductCategoryProductSetSelect = "//tbody/tr/td/div/div/div[2]/div/div[2]/div/div/div/ul/li";
       public static $CrtProductVariantButtonADD = "//tbody/tr/td/div/div/div[1]/div[4]/table/tfoot/tr/td/div/button";
       public static $CrtProductVariantFieldName = "//tbody/tr[2]/td[1]/div/input[3]";
       public static $CrtProductVariantFieldPrice = "//body/div[1]/div[5]/section/form/div/div[2]/div[1]/table[1]/tbody/tr/td/div/div/div[1]/div[4]/table/tbody/tr[2]/td[2]/input";
       public static $CrtProductVariantFieldArticle = "//body/div[1]/div[5]/section/form/div/div[2]/div[1]/table[1]/tbody/tr/td/div/div/div[1]/div[4]/table/tbody/tr[2]/td[4]/input";
       public static $CrtProductVariantFieldAmount = "//body/div[1]/div[5]/section/form/div/div[2]/div[1]/table[1]/tbody/tr/td/div/div/div[1]/div[4]/table/tbody/tr[2]/td[5]/input";
       public static $CrtProductButtonSaveandBack = "//body/div[1]/div[5]/section/div/div[2]/div/button[2]";
       public static $CrtProductButtonCreateProduct = "//body/div[1]/div[5]/form/section/div[1]/div[2]/div/a[2]";
                                                       
       
   //       Delete Product In Category
   public static $DelPrdMainCheckBox = "//body/div[1]/div[5]/form/section/div[2]/table/thead/tr[1]/th[1]/span/span";
   public static $DelPrdButtonDelete = "//body/div[1]/div[5]/form/section/div[1]/div[2]/div/a[1]";
   public static $DelPrdButtonDeleteWindowDelete = "//body/div[1]/div[5]/div[1]/div[3]/a[1]";



   //Defolt Values For Created Products
       
    public static $CrtPrdNameMin = "....."; 
    public static $CrtPrdNameMax = "qwertyuioasdfghjklzxcvbnm????????????????????????????????????????????????????????????????????QWERTYUIOPASDFGHJKLZXCVBNM??????????????????????????????????????????????????????????????????qwertyuioasdfghjklzxcvbnm????????????????????????????????????????????????????????????????????QWERTYUIOPASDFGHJKLZXCVBNM??????????????????????????????????????????????????????????????????qwertyuioasdfghjklzxcvbnm????????????????????????????????????????????????????????????????????QWERTYUIOPASDFGHJKLZXCVBNM??????????????????????????????????????????????????????????????????qwertyuioasdfghjklzxcvbnm????????????????????????????????????????????????????????????????????QWERTYUIOPASDFGHJKLZXCVBNM??????????????????????????????????????????????????????????????????QWEQWEQWEQWEQWEASDASDZXCASDQ"; 
    public static $CrtPrdPriceMin = "1"; 
    public static $CrtPrdPriceMax = "10000000000000"; 
    public static $CrtPrdArticleMin = "R2D2"; 
    public static $CrtPrdArticleMax = "??????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????"; 
    public static $CrtPrdAmountMin = "0"; 
    public static $CrtPrdAmountMax = "2147483647"; 
    public static $CrtVarNameMin = "VoP"; 
    public static $CrtVarNameMax = "????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????"; 
    public static $CrtVarPriceMin = "1"; 
    public static $CrtVarPriceMax = "10000000000000"; 
    public static $CrtVarArticleMin = "D3R3"; 
    public static $CrtVarArticleMax = "??????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????"; 
    public static $CrtVarAmountMin = "0"; 
    public static $CrtVarAmountMax = "2147483647"; 
}

