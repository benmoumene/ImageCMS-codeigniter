        <a href="{shop_url('wish_list')}" class="items" rel="nofollow">
            {echo ShopCore::app()->SWishList->totalItems()}
            {echo SStringHelper::Pluralize(ShopCore::app()->SWishList->totalItems(), array(lang('товар', 'newLevel'),lang('товара', 'newLevel'),lang('товаров', 'newLevel')))}
        </a>
        <span class="prices">{echo ShopCore::app()->SWishList->totalPrice()} {$CS} 
            <a rel="nofollow" href="{shop_url('wish_list')}" class="image"><img src="{$SHOP_THEME}style/images/wish_list.png" width="22" height="22" border="0" alt="mycart" /></a>
        </span>

