{# Variables
# @var model
# @var editProductUrl
# @var jsCode
#}

{$jsCode}

<script type="text/javascript">
    var currentProductId = '{echo $model->getId()}';
</script>

<!-- BEGIN STAR RATING -->
<link rel="stylesheet" type="text/css" href="{$SHOP_THEME}js/rating/jquery.rating-min.css" />
<script src="{$SHOP_THEME}js/rating/jquery.rating-min.js"></script>
<script src="{$SHOP_THEME}js/rating/jquery.MetaData-min.js"></script>
<script src="{$SHOP_THEME}js/product.js"></script>
<!-- END STAR RATING -->

<!-- BEGIN LIGHTBOX -->
<script type="text/javascript" src="{$SHOP_THEME}js/lightbox/scripts/jquery.color.min.js"></script>
<script type="text/javascript" src="{$SHOP_THEME}js/lightbox/scripts/jquery.lightbox.min.js"></script>
<link type="text/css" rel="stylesheet" media="screen" href="{$SHOP_THEME}js/lightbox/styles/jquery.lightbox.min.css" />
<!-- END LIGHTBOX -->

{# Display sidebar.tpl #}
{include_tpl ('sidebar')}

<div class="products_list">

    <div id="titleExt">
        <h5 class="left">
            {echo ShopCore::encode($model->getName())}
            {if sizeof($model->getProductVariants()) == 1}
                {echo $model->firstVariant->getName()}
            {/if}
        </h5>
        <div class="right">
            {$rating = $model->getRating()}
            <input class="hover-star" type="radio" name="rating-1" value="1" {if $rating==1}checked="checked"{/if}/>
            <input class="hover-star" type="radio" name="rating-1" value="2" {if $rating==2}checked="checked"{/if}/>
            <input class="hover-star" type="radio" name="rating-1" value="3" {if $rating==3}checked="checked"{/if}/>
            <input class="hover-star" type="radio" name="rating-1" value="4" {if $rating==4}checked="checked"{/if}/>
            <input class="hover-star" type="radio" name="rating-1" value="5" {if $rating==5}checked="checked"{/if}/>
        </div>
        <div class="sp"></div>

        <div id="categoryPath">
            {renderCategoryPath($model->getMainCategory())}
        </div>
    </div>

    {if $CI->session->flashdata('productAdded') === true}
        <div style="padding:10px;background-color:#f5f5dc;">
            ?????????? ???????????????? ?? <a href="{shop_url('cart')}" rel="nofollow">??????????????.</a>
        </div>
    {/if}
    <br/>
    {if ShopCore::$ci->dx_auth->is_admin()}
        <div style="float:right;"><a target="_blank" href="/admin?r=admin/components/run/shop/products/edit/{echo $editProductUrl}/&b=shopAdminPage">?????????????????????????? ??????????</a></div>
    {/if}
    <div class="left">

        <div id="gallery">
            <div id="prImage" align="center">
                {if $model->getMainImage()}
                    <img src="{productImageUrl($model->getMainImage())}" border="0" alt="{echo encode($model->getName())}" width="300px" />
                {/if}
            </div>

            {if sizeof($model->getSProductImagess()) > 0}
                {foreach $model->getSProductImagess() as $image}
                    <div class="images">
                        <div class="image">
                            <a class="lightbox" alt="{echo encode($model->getName())}" href="{echo $image->getUrl()}">
                                <img src="{echo $image->getThumbUrl()}" style="width:90px;">
                            </a>
                        </div>
                    </div>
                {/foreach}
            {/if}
        </div>

    </div>
    <div id="product" style="width:380px;">
        <div id="detail">
            <h3>???????????????? ????????????????:</h3>
            {echo $model->getShortDescription()}
            {echo $model->getFullDescription()}

            {if $model->countProperties() > 0}
                <h3>????????????????????????????:</h3>
                <div id="productProperties">
                    {echo ShopCore::app()->SPropertiesRenderer->renderPropertiesTable($model)}
                </div>
            {/if}
        </div>

        <div class="right">
            <form action="{shop_url('cart/add')}" name="productForm" id="productForm" method="post">

                {if $model->countProductVariants() > 1}
                    <!-- See products.js::display_variant_price() for more details -->
                    <div align="right" style="padding-bottom:20px;">
                        ???????????????? ????????????:
                        <select name="variantId" onChange="display_variant_price(this.value)">
                            {foreach $model->getProductVariants() as $variant}
                                <option value="{echo $variant->getId()}">{echo ShopCore::encode($variant->getName())}</option>
                            {/foreach}
                        </select>
                    </div>
                {else:}
                    <input type="hidden" name="variantId" value="{echo $model->firstVariant->getId()}" />
                {/if}


                <div class="price">
                    <span id="price">{echo $model->firstVariant->toCurrency()} {$CS}</span>

                    <!-- ???????????? ???????? -->
                    {if $model->getOldPrice() > 0}
                        <div style="font-size:13px;color:#000">
                            ???????????? ????????: <span style="color:red;"><s>{echo $model->toCurrency('OldPrice')} {$CS}</s></span>
                        </div>
                    {/if}

                    <!-- ?????????????? ?????????????? ?????? ?????????? ????????????(???????? ????????) -->
                    {if $model->hasDiscounts()}
                        <div style="font-size:12px;color:#d2691e;">
                            ???? ???????????? ?????????????? ?????????????????? ???????????? {echo $model->getDiscountString()}
                        </div>
                    {/if}
                </div>

                <!-- See products.js::display_variant_price() for more details -->
                <div align='right' style="font-size:12px;color:#669900;">
                    {if $model->firstVariant->getStock() > 0}
                        <span id="stock">???????? ???? ????????????</span>
                    {else:}
                        <span id="stock">?????? ???? ????????????</span>
                    {/if}
                </div>
                <a id="send-request" style="float:right;font-size: 13px;cursor: pointer;display:{if $model->firstVariant->getStock()}none{else:}block{/if};">???????????????? ?? ??????????????????</a><br />
                <input type="hidden" name="productId" value="{echo $model->getId()}" />
                <input type="hidden" name="quantity" value="1" />

                {if $model->firstVariant->getStock() > 0}
                    <a rel="nofollow" href="#" onClick='ajaxAddToCart("{shop_url("cart/add")}", "{shop_url("ajax/getCartDataHtml")}");
        return false;' class="button1">{echo ShopCore::t('???????????????? ?? ??????????????')}</a>
                {else:}

                {/if}
                <div style="margin-left:45px;font-size:13px;display:none;background-color:#f5f5dc;" id="cartNotify">
                    ?????????? ???????????????? ?? ??????????????.
                </div>
                <a rel="nofollow" href="#" onClick='ajaxAddToWishList();
        return false;' class="button1">{echo ShopCore::t('???????????????? ?? WISH LIST')}</a>
                <div style="margin-left:45px;font-size:13px;display:none;background-color:#f5f5dc;" id="wishListNotify">
                    ?????????? ???????????????? ?? Wish List.
                </div>

                <div id="dialog-form" title="???????????????? ?? ??????????????????" style="height: 575px;">
                    <span style="font-weight: bold; font-size: 14px;">{echo $model->getName()}</span>
                    <div id="notifyProductVariantName" style="font-weight: bold; font-size: 13px;">{echo $model->firstVariant->getName()}</div>
                    <p class="validateTips" style="color: #d2691e;"></p>
                    <form>
                        <fieldset>
                            <label for="name">???????? ??????:</label>
                            <input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" />
                            <label for="email">Email:</label>
                            <input type="text" name="email" id="email" value="" class="text ui-widget-content ui-corner-all" />
                            <label for="phone">?????????????????? ??????????????:</label>
                            <input type="text" name="phone" id="phone" value="" class="text ui-widget-content ui-corner-all" />
                            <label for="actual">?????????????????? ????:</label>
                            <input type="text" name="actual" id="actual" value="????-????-????????" class="text ui-widget-content ui-corner-all" style="background-image: url('{$SHOP_THEME}style/images/calendar.png'); background-position: right center; background-repeat: no-repeat;" />
                            <label for="comment">???????????????????????????? ????????????????????:</label>
                            <textarea name="comment" id="comment" class="text ui-widget-content ui-corner-all" style="min-width: 95%;height: 75px;"></textarea>
                        </fieldset>
                    </form>
                </div>
                {form_csrf()}
            </form>
        </div>

        <div class="spRight"></div>
    </div>

    <div class="sp"></div>
    {if $model->getRelatedProductsModels()}
        <h5>?????????????????????????? ????????????</h5>
        {# Display list of related products #}
        <ul class="products">
            {$count = 1}
            {foreach $model->getRelatedProductsModels() as $p}
                <li {if $count == 3} class="last" {$count = 0}{/if}>
                    <div class="image" style="display:table-cell;vertical-align:middle;overflow:hidden;">
                        <a href="{shop_url('product/' . $p->getUrl())}">
                            <img src="{productImageUrl($p->getId() . '_small.jpg')}" border="0"  alt="image" />
                        </a>
                    </div>
                    <h3 class="name"><a href="{shop_url('product/' . $p->getUrl())}">{echo ShopCore::encode($p->getName())}</a></h3>
                    <div class="price">
                        {$p->firstVariant}
                        {if $p->hasDiscounts()}
                            <s>{echo $p->firstVariant->toCurrency('origPrice')} {$CS}</s>
                            <br/>
                            <span style="font-size:14px;">{echo $p->firstVariant->toCurrency()} {$CS}</span>
                        {else:}
                            <span style="font-size:14px;">{echo $p->firstVariant->toCurrency()} {$CS}</span>
                        {/if}
                    </div>
                    <div class="compare"><a href="{shop_url('compare/add/' . $p->getId())}">????????????????</a></div>
                </li>
            {if $count == 3}<li class="separator"></li> {$count=0}{/if}
                {$count++}
            {/foreach}
    </ul>
{/if}

<div class="sp"></div>
{if $model->getKits()->count() > 0}
    {$kits = $model->getKits()}
    <h5>???????????? ??????????????</h5>
    {# Display the list of product kits #}
    <ul class="products">
        {$count = 1}
        <li {if $count == 3}class="last"{$count = 0}{/if}>
            <div class="image" style="display:table-cell;vertical-align:middle;overflow:hidden;">
                <a href="{shop_url('product/' . $kits[0]->getMainProduct()->getUrl())}">
                    <img src="{productImageUrl($kits[0]->getMainProduct()->getId() . '_small.jpg')}" border="0"  alt="image" />
                </a>
            </div>
            <h3 class="name"><a href="{shop_url('product/' . $kits[0]->getMainProduct()->getUrl())}">{echo ShopCore::encode($kits[0]->getMainProduct()->getName())}</a></h3>
            <div class="price">
                {$firstVariant = $kits[0]->getMainProduct()->getFirstVariant()}
                <span style="font-size:14px;">{echo $firstVariant->toCurrency()} {$CS}</span>
            </div>
            <div class="compare"><a href="{shop_url('compare/add/' . $kits[0]->getMainProduct()->getId())}">????????????????</a></div>
        </li>
        {$isAvailable = TRUE}
        {foreach $kits[0]->getShopKitProducts() as $shopKitProduct}
            {$ap = $shopKitProduct->getSProducts()}
            {$ap->setLocale(MY_Controller::getCurrentLocale())}
            <li {if $count == 3}class="last"{$count = 0}{/if}>
                <div class="image" style="display:table-cell;vertical-align:middle;overflow:hidden;">
                    <a href="{shop_url('product/' . $ap->getUrl())}">
                        <img src="{productImageUrl($ap->getId() . '_small.jpg')}" border="0"  alt="image" />
                    </a>
                </div>
                <h3 class="name"><a href="{shop_url('product/' . $ap->getUrl())}">{echo ShopCore::encode($ap->getName())}</a></h3>
                <div class="price">
                    {$kitFirstVariant = $ap->getKitFirstVariant($shopKitProduct)}
                    {if $kitFirstVariant->getEconomy() > 0}
                        <s>{echo $kitFirstVariant->toCurrency('origPrice')} {$CS}</s>
                        <br/>
                        <span style="font-size:14px;">{echo $kitFirstVariant->toCurrency()} {$CS}</span>
                    {else:}
                        <span style="font-size:14px;">{echo $kitFirstVariant->toCurrency()} {$CS}</span>
                    {/if}
                </div>
                <div class="compare"><a href="{shop_url('compare/add/' . $ap->getId())}">????????????????</a></div>
            </li>
        {if $count == 3}<li class="separator"></li> {$count=0}{/if}
            {$count++}
            {if $kitFirstVariant->getStock() < 1}
                {$isAvailable = FALSE}
            {/if}
        {/foreach}
</ul>
<div class="sp"></div>
<div style="float: right;">
    {if $isAvailable}
        <a rel="nofollow" href="#" onClick='ajaxAddKitToCart({echo $kits[0]->getId()}, "{shop_url("cart/add/ShopKit")}", "{shop_url("ajax/getCartDataHtml")}");
        return false;'>{echo ShopCore::t('???????????????? ???????????????? ?? ??????????????')}</a>
    {else:}
        ?????? ???? ????????????
    {/if}
</div>
{/if}

<div class="sp"></div>
{$comments}
</div>