<section class="mini-layout mod_stats">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Stats', 'mod_stats')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="" class="t-d_n m-r_15"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Back', 'admin')}</span></a>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        {include_tpl('../include/left_block')}
        <div class="clearfix span9" id="chartArea">
            {include_tpl('../include/top_form_categories_attendance')}
            <button  class="btn btn-small btn-primary" id="saveAsPng">
                <i class="icon-download"></i> {lang('Save Image', 'mod_stats')}</button>
            <svg class="cumulativeLineChartStats" data-from="categories/getCategoriesAttendanceData" style="height: 600px; width: 800px;"></svg>

        </div>
    </div>
</section>