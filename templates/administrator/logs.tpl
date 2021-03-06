<div class="container">
    <section class="mini-layout">
        <div class="frame_title clearfix">
            <div class="pull-left">
                <span class="help-inline"></span>
                <span class="title">{lang("Event journal","admin")}</span>
            </div>                                                   
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="modules">
                <div class="row-fluid">
                    <div class="form-horizontal">
                        <table class="table table-striped table-bordered table-hover table-condensed t-l_a">
                            <thead>
                                <tr>                                              
                                    <th>{lang("User","admin")}</th>
                                    <th>{lang("Date/time", "admin")}</th>
                                    <th>{lang("Action","admin")}</th>
                                </tr>
                            </thead>
                            <tbody class="sortable ui-sortable">
                                {foreach $messages as $m}                                  
                                <td><p>{$m.username}</p></td>
                                <td><p>{date('d-m-Y H:i:s', $m.date)}</p></td>
                                <td><p>{$m.message}</p></td>
                                </tr>
                            {/foreach}                                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>   
            <div class="clearfix">
                    {$paginator}
            </div>
    </section>
</div>