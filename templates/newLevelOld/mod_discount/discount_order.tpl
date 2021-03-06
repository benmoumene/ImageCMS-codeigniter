

{if $discount->sum_discount_product > $discount->sum_discount_no_product}
    <div>
        <span class="s-t">{lang('Тип скидки: ','newLevel')}</span>
        <span class="price-item">{lang('Продуктовый','newLevel')}</span>
    </div>
    <div>
        <span class="s-t">{lang('Размер скидки:','newLevel')}</span>
        <span class="price-item">
            <span class="text-discount">
                <span class="price">{echo $discount->result_sum_discount_convert}</span>
                <span class="curr">{$CS}</span>
            </span>
        </span>
    </div>
{else:}
{if $discount->max_discount->type_value == 1} {$type_value = "%"} {else:}{$type_value = "{lang('Цифровой','newLevel')}"}{/if}
<div>
    <span class="s-t">{lang('Тип скидки: ','newLevel')}</span>
    <span class="price-item">{echo $discount->max_discount->type_discount}</span>
</div>
<div>
    <span class="s-t">{lang('Размер скидки: ','newLevel')}</span>
    <span class="price-item">{echo $discount->max_discount->value} {echo $type_value}</span>
</div>
<div>
    <span class="s-t">{lang('Общая скидка: ','newLevel')}</span>
    <span class="price-item text-discount"><span>{echo $discount->result_sum_discount_convert} <span class="curr">{$CS}</span></span></span>
</div>
{/if}