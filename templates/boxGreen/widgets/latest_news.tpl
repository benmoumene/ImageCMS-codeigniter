{if count($recent_news) > 0}
    <div class="frame-news">
        <div class="title-news">
            <div class="frame-title">
                <div class="title-h1 d_i title">{lang('Новости','boxGreen')}</div>
            </div>
        </div>
        <ul class="items items-news">
            {foreach $recent_news as $item}
                {$item = $CI->load->module('cfcm')->connect_fields($item, 'page')}
                <li>
                    <a href="{site_url($item.full_url)}" class="frame-photo-title">
                        {if trim($item.field_list_image) != ""}
                            <span class="d_b">
                                <span class="photo-block">
                                    <span class="helper"></span>
                                    <img src="{$item.field_list_image}" alt="" />
                                </span>
                            </span>
                        {/if}
                        <span class="title">{$item.title}</span>
                    </a>
                    <div class="description">
                        {if trim($item.field_info) != ""}
                            <div class="info">{$item.field_info}</div>
                        {/if}
                        <div class="date f-s_0">
                            <span class="icon_time"></span><span class="text-el"></span>
                            <span class="day">{echo date("d", $item.publish_date)} </span>
                            <span class="month">{echo month(date("n", $item.publish_date))} </span>
                            <span class="year">{echo date("Y ", $item.publish_date)}</span>
                        </div>
                    </div>
                </li>
            {/foreach}
        </ul>
    </div>
{/if}