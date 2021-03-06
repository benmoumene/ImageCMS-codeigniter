{#
/**
* @file Template. Displaying order view page;
* @partof main.tpl;
* Variables
*   $model : (object) instance of SOrders;
*    $model->getId() : return Order ID;
*    $model->getPaid() : return Order paid status;
*    $model->getSDeliveryMethods()->getName() : get Delivery method name;
*    $model->getOrderProducts() : return Ordered products list;
*    $model->getOrderKits() : return Ordered Kits list;
*    $model->getTotalPrice() : get aggregate ordered Products Price;
*    $model->getDeliveryPrice() : return delivery Price;
*    $model->getTotalPriceWithDelivery() : sum of Product and Delivery Prices;
*    $model->getTotalPriceWithGift() : difference of previous price (getTotalPriceWithDelivery) and gift certificate price;
* @updated 27 January 2013;
*/
#}
{$NextCSIdCond = $NextCS != null}
<div class="frame-inside page-order">
    <div class="container">
        {if $CI->session->flashdata('makeOrder') === true}
            <div class="f-s_0 without-crumbs">
                <div class="frame-title">
                    <h1 class="title">{lang('Спасибо, ваш заказ принят!', 'lightRed')}<br/>{lang('Наши менеджеры свяжутся с вами.','lightRed')}</h1>
                </div>
            </div>
        {/if}
        <div class="f-s_0 title-order-view without-crumbs">
            <div class="frame-title">
                <h1 class="d_i">{lang('Заказ №','lightRed')}:<span class="number-order">{echo $model->getId()}</span></h1>
            </div>
        </div>
        {$total = $model->getTotalPrice()}
        <!-- Start. Displays a information block about Order -->
        <div class="left-order">
            <!--                Start. User info block-->
            <table class="table-info-order">
                <colgroup>
                    <col width="120"/>
                </colgroup>
                <tr>
                    <th>{lang('Имя получателя','lightRed')}:</th>
                    <td>{echo $model->getUserFullName()}</td>
                </tr>
                {if $model->getUserPhone()}
                    <tr>
                        <th>{lang('Телефон','lightRed')}:</th>
                        <td>{echo $model->getUserPhone()}</td>
                    </tr>
                {/if}
                <tr>
                    <th>E-mail:</th>
                    <td>{echo $model->getUserEmail()}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr/>
                    </td>
                </tr>
                <!-- Start. Delivery Method name -->
                <tr>
                    <th>{lang('Способ доставки','lightRed')}:</th>
                    <td>
                        {if $model->getDeliveryMethod() > 0}
                            {echo $model->getSDeliveryMethods()->getName()}
                        {/if}
                    </td>
                </tr>
                <!-- End. Delivery Method name -->
                {$s_field = ShopCore::app()->CustomFieldsHelper->getOneCustomFieldsByNameArray('city','order', $model->getId())}{echo $s_field.field_data}
                {if $s_field}
                    <tr>
                        <th>{lang('Город','lightRed')}:</th>
                        <td>{echo $s_field}</td>
                    </tr>
                {/if}
                {if $model->getUserDeliverTo()}
                    <tr>
                        <th>{lang('Адрес','lightRed')}:</th>
                        <td>{echo $model->getUserDeliverTo()}</td>
                    </tr>
                {/if}
                {if $model->getUserComment()}
                    <tr>
                        <th>{lang('Комментарий','lightRed')}:</th>
                        <td>{echo $model->getUserComment()}</td>
                    </tr>
                {/if}

                {$fields = ShopCore::app()->CustomFieldsHelper->getCustomFielsdAsArray('order',$profile.id,'user')}
                <!--                End. User info block-->
                <tr>
                    <td colspan="2">
                        <hr/>
                    </td>
                </tr>
                <tr>
                    <th>{lang('Дата заказа','lightRed')}:</th>
                    <td>{date('d.m.Y, H:i:s.',$model->getDateCreated())} </td>
                </tr>
                <!-- Start. Render certificate -->
                {$giftCond = $model->getGiftCertKey() != null}
                {if $giftCond}
                    {$giftPrice = (float)$model->getGiftCertPrice()}
                    {$total -= $giftPrice}
                {else:}
                    {$giftPrice = 0}
                {/if}
                <!-- End. Render certificate -->

                <!-- Start. Delivery Method price -->
                {if (int)$model->getDeliveryPrice() > 0}
                    {$total = $total + $model->getDeliveryPrice()}
                {/if}
                <!-- End. Delivery Method price -->

                <!-- Start. Render payment button and payment description -->
                <tr>
                    <th>{lang('Способ оплаты','lightRed')}:</th>
                    <td>
                        {if $model->getPaid() != true && $model->getTotalPriceWithGift() > 0}
                            {if $paymentMethod->getName()}
                                {echo ShopCore::t($paymentMethod->getName())}
                            {/if}
                        {/if}
                    </td>
                </tr>
                <!--                Start. Order status-->
                <tr>
                    <th>{lang('Статус оплаты','lightRed')}:</th>
                    <td>
                        {if $model->getPaid() == true}
                            <span class="status-pay paid">{lang('Оплачен','lightRed')}</span>
                        {else:}
                            <span class="status-pay not-paid">{lang('Не оплачен','lightRed')}</span>
                        {/if}
                    </td>
                </tr>
                <!--                End. Order status-->
                <tr>
                    <td></td>
                    <td>
                        <div class="frame-payment">
                            {$locale = \MY_Controller::getCurrentLocale();}
                            {/*$notif = $CI->db->where('locale', $locale)->where('name','callback')->get('answer_notifications')->row()*/}
                            {/*echo $notif->message*/}
                            {echo $paymentMethod->getPaymentForm($model)}
                        </div>
                    </td>
                </tr>
                <!-- End. Render payment button and payment description -->
            </table>
        </div>
        <!-- End. Displays a information block about Order -->
        <div class="right-order">
            <div class="frame-bask frame-bask-order">
                <div class="frame-bask-scroll">
                    <div class="inside-padd">
                        <table class="table-order table-order-view">
                            <colgroup>
                                <col/>
                                <col width="120"/>
                            </colgroup>
                            <tbody>
                                <!-- for single product -->
                                {foreach $model->getOrderProducts() as $orderProduct}
                                    {foreach $orderProduct->getSProducts()->getProductVariants() as $v}
                                        {if $v->getid() == $orderProduct->variant_id}
                                            {$Variant = $v}
                                            {break;}
                                        {/if}
                                    {/foreach}
                                    <tr class="items items-bask items-order cart-product">
                                        <td class="frame-items">
                                            <!-- Start. Render Ordered Products -->            
                                            <a href="{shop_url('product/'.$orderProduct->getSProducts()->getUrl())}" class="frame-photo-title">
                                                <span class="photo-block">
                                                    <span class="helper"></span>
                                                    <img alt="{echo ShopCore::encode($orderProduct->product_name)}" src="{echo $Variant->getSmallPhoto()}">
                                                </span>
                                                <span class="title">{echo ShopCore::encode($orderProduct->product_name)}</span>
                                            </a>
                                            <div class="description">
                                                <span class="frame-variant-name-code">
                                                    {if trim(ShopCore::encode($orderProduct->variant_name) != '')}<span class="frame-variant-name frameVariantName">{lang("Вариант",'lightRed')}: <span class="code js-code">{echo ShopCore::encode($orderProduct->variant_name)}</span></span>{/if}
                                                    {if trim(ShopCore::encode($orderProduct->variant_id) != '')}<span class="frame-variant-code frameVariantCode">{lang("Артикул",'lightRed')}: <span class="code js-code">{echo ShopCore::encode($orderProduct->variant_id)}</span></span>{/if}
                                                </span>
                                                {/*}
                                                <span class="frame-prices">
                                                    <span class="current-prices f-s_0">
                                                        <span class="price-new">
                                                            <span>
                                                                <span class="price">{echo $orderProduct->getPrice()}</span>
                                                                <span class="curr">{$CS}</span>
                                                            </span>
                                                        </span>
                                                        {if $NextCSIdCond}
                                                            <span class="price-add">
                                                                <span>
                                                                    <span class="price">{echo ShopCore::app()->SCurrencyHelper->convert($orderProduct->getPrice(), $NextCSId)}</span>
                                                                    <span class="curr-add">{$NextCS}</span>
                                                                </span>
                                                            </span>
                                                        {/if}
                                                    </span>
                                                </span>
                                                { */}
                                        </td>
                                        <td>
                                            <div class="gen-sum-row">
                                                <span class="s-t d_b">{lang('Кол-во','lightRed')}:</span>
                                                <span class="count">{echo $orderProduct->getQuantity()}</span>
                                                <span class="s-t">{lang('шт','lightRed')}.</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="s-t d_b">{lang('Сумма','lightRed')}:</span>
                                            <span class="frame-prices">
                                                <span class="current-prices f-s_0">
                                                    <span class="price-new">
                                                        <span>
                                                            <span class="price">{echo $orderProduct->getPrice()*$orderProduct->getQuantity()}</span>
                                                            <span class="curr">{$CS}</span>
                                                        </span>
                                                    </span>
                                                    {/*}
                                                    {if $NextCSIdCond}    
                                                        <span class="price-add">
                                                            <span>
                                                                <span class="price">{echo ShopCore::app()->SCurrencyHelper->convert($orderProduct->getPrice(), $NextCSId)*$orderProduct->getQuantity($NextCSId)}</span>
                                                                <span class="curr-add">{$NextCS}</span>
                                                            </span>
                                                        </span>
                                                    {/if}
                                                    { */}
                                                </span>
                                            </span>
                                            </div>
                                        </td>
                                    </tr>
                                {/foreach}
                                <!-- end for single product -->
                                <!-- Start. Render Ordered kit products  -->
                                {$sumKit = 0}
                                {foreach $model->getOrderKits() as $orderProduct}
                                    <tr class="row-kits rowKits items-order row">
                                        <td class="frame-items frame-items-kit">
                                            <div class="title-h3 c_9">{lang('Комплект товаров', 'lightRed')}</div>
                                            <ul class="items items-bask">
                                                <li>
                                                    <div class="frame-kit main-product">
                                                        <a href="{shop_url('product/' . $orderProduct->getKit()->getMainProduct()->getUrl())}" class="frame-photo-title">
                                                            <span class="photo-block">
                                                                <span class="helper"></span>
                                                                <img src="{echo $orderProduct->getKit()->getMainProduct()->firstVariant->getSmallPhoto()}" 
                                                                     alt="{echo ShopCore::encode($orderProduct->getKit()->getMainProduct()->getName())}"/>
                                                            </span>
                                                            <span class="title">{echo ShopCore::encode($orderProduct->getKit()->getMainProduct()->getName())}</span>
                                                        </a>
                                                        <div class="description">
                                                            {/*}
                                                            <div class="frame-prices">
                                                                <span class="current-prices">
                                                                    <span class="price-new">
                                                                        <span>
                                                                            <span class="price">{echo $orderProduct->getKit()->getMainProductPrice()}</span>
                                                                            <span class="curr">{$CS}</span>
                                                                        </span>
                                                                    </span>
                                                                    {if $NextCSIdCond}
                                                                        <span class="price-add">
                                                                            <span>
                                                                                <span class="price">{echo $orderProduct->getKit()->getMainProductPrice($NextCSId)}</span>
                                                                                <span class="curr">{$NextCS}</span>
                                                                            </span>
                                                                        </span>
                                                                    {/if}
                                                                </span>
                                                            </div>
                                                            { */}
                                                        </div>
                                                    </div>
                                                    </div>
                                                </li>
                                                {foreach $orderProduct->getKit()->getShopKitProducts() as $key => $kitProducts}
                                                    <li>
                                                        <div class="next-kit">+</div>
                                                        <div class="frame-kit">
                                                            <a href="{shop_url('product/' . $kitProducts->getSProducts()->getUrl())}" class="frame-photo-title">
                                                                <span class="photo-block">
                                                                    <span class="helper"></span>
                                                                    <img src="{echo $kitProducts->getSProducts()->firstVariant->getSmallPhoto()}" 
                                                                         alt="{echo ShopCore::encode($kitProducts->getSProducts()->getName())}"/>
                                                                </span>
                                                                <span class="title">{echo ShopCore::encode($kitProducts->getSProducts()->getName())}</span>
                                                            </a>
                                                            <div class="description">
                                                                {/*}
                                                                <div class="frame-prices">
                                                                    {if $kitProducts->getDiscount()}
                                                                        <span class="price-discount">
                                                                            <span>
                                                                                <span class="price priceOrigVariant">{echo $kitProducts->getKitProductPrice()}</span>
                                                                                <span class="curr">{$CS}</span>
                                                                            </span>
                                                                        </span>
                                                                    {/if}
                                                                    <span class="current-prices">
                                                                        <span class="price-new">
                                                                            <span>
                                                                                <span class="price">{echo $kitProducts->getKitNewPrice()}</span>
                                                                                <span class="curr">{$CS}</span>
                                                                            </span>
                                                                        </span>
                                                                        {if $NextCSIdCond}    
                                                                            <span class="price-add">
                                                                                <span>
                                                                                    <span class="price">{echo $kitProducts->getKitNewPrice($NextCSId)}</span>
                                                                                    <span class="curr">{$NextCS}</span>
                                                                                </span>
                                                                            </span>
                                                                        {/if}
                                                                    </span>
                                                                </div>
                                                                { */}
                                                            </div>
                                                        </div>
                                                    </li>
                                                {/foreach}
                                            </ul>
                                        </td>
                                        <td>
                                            <div class="gen-sum-row">
                                                <span class="s-t d_b">{lang('Кол-во','lightRed')}:</span>
                                                <span class="count">{echo $orderProduct->getQuantity()}</span>
                                                <span class="s-t">{lang('шт','lightRed')}.</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="s-t">{lang('Сумма','lightRed')}:</span>
                                            <span class="frame-prices">
                                                <span class="price-discount">
                                                    <span>
                                                        <span class="price">{echo $orderProduct->getKit()->getTotalPriceOld()}</span>
                                                        <span class="curr">{$CS}</span>
                                                    </span>
                                                </span>
                                                <span class="current-prices f-s_0">
                                                    <span class="price-new">
                                                        <span>
                                                            <span class="price">{echo $orderProduct->getKit()->getTotalPrice()}</span>
                                                            <span class="curr">{$CS}</span>
                                                        </span>
                                                    </span>
                                                    {/*}
                                                    {if $NextCSIdCond}
                                                        <span class="price-add">
                                                            <span>
                                                                <span class="price">{echo $orderProduct->getKit()->getTotalPrice($NextCSId)}</span>
                                                                <span class="curr-add">{$NextCS}</span>
                                                            </span>
                                                        </span>
                                                    {/if}
                                                    { */}
                                                </span>
                                                {$sumKit += $orderProduct->getKit()->getTotalPrice() - $orderProduct->getKit()->getTotalPriceOld()}
                                            </span>
                                        </td>
                                    </tr>
                                {/foreach}
                            </tbody>
                            <tfoot class="gen-info-price">
                                {if $model->getOriginPrice()}
                                    <tr>
                                        <td colspan="2">
                                            <span class="s-t">{lang('Сумма товаров','lightRed')}</span>
                                        </td>
                                        <td>
                                            <span class="price-new">
                                                <span>
                                                    <span class="price">{echo ShopCore::app()->SCurrencyHelper->convert($model->getOriginPrice())}</span>
                                                    <span class="curr">{$CS}</span>
                                                </span>
                                            </span>
                                        </td>
                                    </tr>
                                {/if}
                                <tr>
                                    <td colspan="2">
                                        <span class="s-t">{lang('Стоимость доставки','lightRed')}:</span>
                                    </td>
                                    <td>
                                        <span class="price-item">
                                            <span>
                                                <span class="price">{echo ShopCore::app()->SCurrencyHelper->convert($model->getDeliveryPrice())}</span>
                                                <span class="curr">{$CS}</span>
                                            </span>
                                        </span>
                                    </td>
                                </tr>

                                {$discount = ShopCore::app()->SCurrencyHelper->convert($model->getdiscount())}
                                {if $discount || $sumKit != 0}
                                    <tr>
                                        <td colspan="2">
                                            <span class="s-t">{lang('Ваша текущая скидка','lightRed')}:</span>
                                        </td>
                                        <td>
                                            <span class="price-item">
                                                <span>
                                                    <span class="text-discount current-discount">{echo $discount + $sumKit} <span class="curr">{$CS}</span></span>
                                                </span>
                                            </span>
                                        </td>
                                    </tr>
                                {/if}
                                {if $model->getGiftCertPrice() > 0}
                                    <tr>
                                        <td colspan="2">
                                            <span class="s-t">{lang('Подарочный сертификат','lightRed')}:</span>
                                        </td>
                                        <td>
                                            <span class="price-item">
                                                <span class="text-discount">
                                                    <span class="price">- {echo ShopCore::app()->SCurrencyHelper->convert($model->getGiftCertPrice())} </span>
                                                    <span class="curr">{$CS}</span>
                                                </span>
                                            </span>
                                        </td>
                                    </tr>
                                {/if}
                            </tfoot>

                            <!-- End. Render Ordered kit products  -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="footer-bask">
                    <div class="inside-padd">
                        <!-- Start. Price block-->
                        <div class="gen-sum-order clearfix">
                            <span class="title f_l">{lang('К оплате','lightRed')}:</span>
                            <span class="frame-prices f-s_0 f_r">
                                <span class="current-prices f-s_0">
                                    <span class="price-new">
                                        <span>
                                            <span class="price">{echo $model->gettotalprice() + ShopCore::app()->SCurrencyHelper->convert($model->getDeliveryPrice())}</span>
                                            <span class="curr">{$CS}</span>
                                        </span>
                                    </span>
                                    {if $NextCSIdCond}     
                                        <span class="price-add">
                                            <span>
                                                (<span class="price" id="totalPriceAdd">{echo $model->gettotalprice($NextCSId) + ShopCore::app()->SCurrencyHelper->convert($model->getDeliveryPrice(),$NextCSId)}</span>                                            <span class="curr-add">{$NextCS}</span>)
                                            </span>
                                        </span>
                                    {/if}
                                </span>
                            </span>
                        </div>
                        <!-- End. Price block-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>