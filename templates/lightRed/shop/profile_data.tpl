<div class="inside-padd clearfix">
    <div class="frame-change-profile">
        <div class="horizontal-form">
            <form method="post" id="form_change_info" onsubmit="ImageCMSApi.formAction('{site_url("/shop/profileapi/changeInfo")}', '#form_change_info', {literal}{hideForm: false, durationHideForm: 1000}{/literal});
                    return false;">
                <label>
                    <span class="title">{lang('Ваше имя','lightRed')}:</span>
                    <span class="frame-form-field">
                        <input type="text" value="{echo encode($profile->getName())}" name="name"/>
                        <span class="help-block">{lang('Не меньше 4-х символов','lightRed')}</span>
                    </span>
                </label>
                <label>
                    <span class="title">{lang('Телефон','lightRed')}:</span>
                    <span class="frame-form-field">
                        <input type="text" value="{echo encode($profile->getPhone())}" name="phone"/>
                    </span>
                </label>
                <label>
                    <span class="title">Email:</span>
                    <span class="frame-form-field">
                        <input type="text" disabled="disabled" value="{echo encode($profile->getUserEmail())}" name="email"/>
                        <input type="hidden" value="{echo encode($profile->getUserEmail())}" name="email"/>
                        <span class="help-block">{lang('E-mail является логином','lightRed')}</span>
                    </span>
                </label>
                {echo ShopCore::app()->CustomFieldsHelper->setRequiredHtml('<span class="must">*</span>')->setPatternMain('pattern_custom_field')->getOneCustomFieldsByName('city','user',$profile->getId())->asHtml()}
                <label>
                    <span class="title">{lang('Адрес','lightRed')}:</span>
                    <span class="frame-form-field">
                        <input type="text" value="{echo encode($profile->getAddress())}" name="address"/>
                    </span>
                </label>
                <div class="frame-label">
                    <span class="title">&nbsp;</span>
                    <span class="frame-form-field">
                        <span class="btn-form">
                            <input type="submit" value="{lang('Сохранить данные','lightRed')}"/>
                        </span>
                    </span>
                </div>
                {form_csrf()}
            </form>
        </div>
    </div>
            
    
    {$dApi = $CI->load->module('mod_discount/discount_api')}
    {if $dApi->discountsExists()}
        {$discount = $dApi->get_user_discount_api()}
        <div class="layout-highlight info-discount">
            <div class="title-default">
                <div class="title">{lang('Скидки','lightRed')}</div>
            </div>
            <div class="content">
                <ul class="items items-info-discount">
                    <li class="inside-padd">
                        <div>
                            {lang('Товаров на сумму','lightRed')}:
                            <span class="price-item">
                                <span class="text-discount">
                                    <span class="price">{echo ShopCore::app()->SCurrencyHelper->convert($profile->getamout())}</span>
                                    <span class="curr">{$CS}</span>
                                </span>
                            </span>
                        </div>
                        {if $dApi->userDiscountExists()}
                            <div>
                                {lang('Ваша текущая скидка','lightRed')}:
                                <span class="price-item">
                                    <span class="text-discount">{echo $discount['user'][0]['value']}{if $discount['user'][0]['type_value'] == 1}%{else:}{$CS}{/if}</span>
                                </span>
                            </div>
                        {/if}
                        {if $dApi->groupDiscountExists()}
                            <div>
                                {lang('Ваша текущая скидка группы пользователей','lightRed')}:
                                <span class="price-item">
                                    <span class="text-discount">{echo $discount['group_user'][0]['value']}{if  $discount['group_user'][0]['type_value'] == 1}%{else:}{$CS}{/if}</span>
                                </span>
                            </div>
                        {/if}
                        {if $discount['comulativ']}
                            {foreach $discount['comulativ'] as $key => $disc}
                                {if $disc['begin_value'] < $profile->getamout() and $profile->getamout() < $disc['end_value']}
                                    {$discount_comul_next = $discount['comulativ'][$key + 1];}
                                    {$discount_comul_curr = $discount['comulativ'][$key];}
                                {/if}
                            {/foreach}
                        {/if}
                        {if $discount_comul_curr}
                            <div>
                                {lang('Ваша текущая скидка','lightRed')}:
                                <span class="price-item">
                                    <span class="text-discount">{echo $discount_comul_curr['value']}{if  $discount_comul_curr['type_value'] == 1}%{else:}{$CS}{/if}</span>
                                </span>
                            </div>
                        {/if}

                    </li>

                    {if $discount_comul_next}
                        <li class="inside-padd">
                            <div>{lang('Для следующей скидки','lightRed')} {echo $discount_comul_next['value']}{if  $discount_comul_next['type_value'] == 1}%{else:}{$CS}{/if}</b> {lang('осталось','lightRed')}</div>
                            <div>{lang('cделать покупки на сумму','lightRed')}: <b>{echo $discount_comul_next['begin_value'] - $profile->getamout()} {$CS}</b></div>
                        </li>
                    {/if}
                    {if  $discount['comulativ']}
                        <li class="inside-padd">
                            <button type="button" class="d_l_1" data-drop=".drop-comulativ-discounts" data-place="noinherit" data-placement="bottom left" data-overlay-opacity= "0">{lang('Посмотреть таблицу скидок','lightRed')}</button>
                        </li>
                    {/if}
                </ul>
            </div>
        </div>
    </div>
{/if}
{if  $discount['comulativ']}
    <div class="drop-style drop drop-comulativ-discounts">
        <button type="button" class="icon_times_drop" data-closed="closed-js"></button>
        <div class="drop-header">
            <div class="title">{lang('Накопительные скидки','lightRed')}</div>
        </div>
        <div class="drop-content">
            <div class="inside-padd characteristic">
                <table class="">
                    <thead>
                        <tr>
                            <th>{lang('Размер скидки','lightRed')}</th>
                            <th>{lang('От','lightRed')}</th>
                            <th>{lang('До','lightRed')}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $discount['comulativ'] as $disc}
                            <tr>
                                <td class="text-discount">{echo $disc['value']}{if $disc['type_value'] == 1}%{else:}{$CS}{/if}</td>
                                <td>{echo $disc['begin_value']} {$CS}</td>
                                <td>{if $disc['end_value']}{echo $disc['end_value']} {$CS}{else:}{lang('Бесконечно','lightRed')}{/if}</td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>

            </div>
        </div>
        <div class="drop-footer"></div>
    </div>
{/if}
