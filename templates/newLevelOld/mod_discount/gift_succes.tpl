<div class="groups-form">
    <div class="frame-label" for="giftcert">
        <div class="frame-form-field gift-success">
            {/*echo $gift->key*/}
            <ul class="items items-order-gen-info">
                <li>
                    <span class="price-item">
                        <span class="text-discount">
                            <span class="price">- {echo $gift->value}</span>
                            <span class="curr">{$CS}</span>
                        </span>
                    </span>
                </li>
            </ul>
            <input type="hidden" name="gift" value="{echo $gift->key}"/>
            <input type="hidden" name="gift_ord" value="1"/>
        </div>
    </div>
</div>