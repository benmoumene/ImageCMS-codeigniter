function change_page_status(page_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'admin/pages/ajax_change_status/' + page_id,
        onComplete: function(response) { }
    });
}

$(document).ready(function(){
    $( ".pages-table" ).live( "sortstop", function(event, ui) {
        var positionsArray = {};
        
        $('.pages-table > tbody').children('tr').each(function(){
            positionsArray['pages_pos['+$(this).index()+']'] = 'page'+$(this).attr('data-id')+'_'+$(this).index();
        });
        
        $.ajax({
            type: 'post',
            data: positionsArray,
            url: '/admin/pages/save_positions/',
            success: function(obj){
                if(obj.result){
                    //alert("positions changed successfull");
                }
            }
        });
    });
    
    $('a.ajax_load').click(function(event){
        event.preventDefault();
        $('#mainContent').load($(this).attr('href'));
        /*
        $.ajax({
            type: 'get',
            url: $(this).attr('href'),
            success: function(result){
                $('#mainContent').html(result);
            }
        });
        */
    });
    
    $('#categorySelect').on('change', function(){
        //$('#mainContent').load($(this).attr('url')+$(this).val());
        window.location.href = $(this).attr('url')+$(this).val();
    });
    
    $( "#pages_action_dialog" ).dialog("destroy");
    
    $('button.pages_action').click(function(event){
        event.preventDefault();
        var pagesArray = {};
        var actionURL = $(this).attr('url');
        var checkedPages = $('.pages-table > tbody').children('tr').children('td.t-a_c').find('input:checked');
        
        checkedPages.each(function(){
            pagesArray['pages['+$(this).attr('data-id')+']'] = 'chkb_'+$(this).attr('data-id');
        });
        
        if (checkedPages.size() < 1)
            return false;
        
        if ($(this).hasClass('pages_delete')) {
            $("#pages_delete_dialog").dialog({
                resizable: false,
                height:180,
                modal: true,
                buttons: {
                    "Продолжить": function() {
                        $.ajax({
                            type: 'post',
                            data: pagesArray,
                            url: actionURL,
                            success: function(result){
                                //window.location.href = '/admin/pages/GetPagesByCategory/'+pagesArray['new_cat'];
                                window.location.href = window.location.href;
                            }
                        });
                    },
                    "Отмена": function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        }
        
        else {
            $("#pages_action_dialog").dialog({
                resizable: false,
                height:180,
                modal: true,
                buttons: {
                    "Продолжить": function() {
                        pagesArray['new_cat'] = $('#CopyMoveCategorySelect').val();

                        $.ajax({
                            type: 'post',
                            data: pagesArray,
                            url: actionURL,
                            success: function(result){
                                window.location.href = '/admin/pages/GetPagesByCategory/'+pagesArray['new_cat'];
                            }
                        });
                    },
                    "Отмена": function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        }
        
    });
    
    
    $('.products_table').find('span.prod-on_off').live('click', function(){
        var page_id = $(this).attr('data-id');
        
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/components/run/shop/products/ajaxChangeActive/' + page_id,
            onComplete: function(response) { }
        });
    });
    
    $('.products_table').find('button.setHit').live('click', function(){
        var btn = $(this);
        
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/components/run/shop/products/ajaxChangeHit/' + btn.attr('data-id'),
            onComplete: function(response) {}
        });
        
        btn.toggleClass('btn-primary active');
    });
    
    $('.products_table').find('button.setHot').live('click', function(){
        var btn = $(this);
        
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/components/run/shop/products/ajaxChangeHot/' + btn.attr('data-id'),
            onComplete: function(response) {}
        });
        
        btn.toggleClass('btn-primary active');
    });
    
    $('.products_table').find('button.setAction').live('click', function(){
        var btn = $(this);
        
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/components/run/shop/products/ajaxChangeAction/' + btn.attr('data-id'),
            onComplete: function(response) {}
        });
        
        btn.toggleClass('btn-primary active');
    });
    
});