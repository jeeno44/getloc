$(function(){
    
    preloadLoader('/assets/img/account/loader.gif')
    
    $('.turnLang').click(function(){
        $.ajax({
            url     : "/account/switchingLanguage",
            type    : 'post',
            data    : {langID: parseInt($(this).attr('data-langid'))}
        }); 
    })
    
    $('.tabs__links').find('a').click(function(){
        $('.tabs__links').find('a').each(function(){ $(this).removeClass('active')})
        $(this).addClass('active')
        loadPhrases()
    })
    
    $('#site-list').change(function(){
        window.location.href = $(this).val()
    })
    
    $('#setViewTypeID_1').click(function(){setFilterShow(1);});
    $('#setViewTypeID_2').click(function(){setFilterShow(2);});
    
    $('#check').click(function(){
        $(".checkboxPhrase").prop('checked', $(this).prop("checked"));
    });
    
    $('#check-all-phrases').click(function(){
        setStatusBlock(1)
    })
    
    $('#nopublishing').click(function(){
        setStatusBlock(2)
    })
        
    setEventInContent()
    
    $('#setAutoTranslateProject').click(function()
    {
        $.ajax({
            url     : "/account/setAutoTranslate",
            type    : 'post',
            dataType: 'text',
            cache   : false,
            success : function(res){
                toastr.success(res)
            }
        });
    })
    
    $('#setAutoPublishingProject').click(function()
    {
        $.ajax({
            url     : "/account/setAutoPublishing",
            type    : 'post',
            dataType: 'text',
            cache   : false,
            success : function(res){
                toastr.success(res)
            }
        });
    })

    $('#validate-site').click(function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $.ajax({
            url     : "/account/validate-project/" + id,
            type    : 'get',
            success : function(res) {
                if (res == 'success') {
                    window.location.href  = '/account'
                } else {
                    alert('Скрипт не найден на страницах вашего сайта')
                }
            }
        });
    });
    
    $('.site__aside-filter').find('input[type=radio]').each(function(){
        $(this).click(loadPhrases)
    })



})

setEventInContent = function()
{
    $('.phrases__item-controls-menu').each(function() {
        SubMenu($(this));
    });
    
    $('.save_translate').click(function(){
        
        var blockID = $(this).attr('object-id')
        var type    = $('#order_'+blockID).attr('data-type') 
        
        $.ajax({
            url      : "/account/saveTranslate",
            type     : 'post',
            dataType : 'json',
            data     : {text: $('#order_'+$(this).attr('object-id')).val(), id: $(this).attr('object-id'), type: parseInt(type)},
            success  : function(response)
            {
                toastr.success(response.message)
                setNewStats(response.stats)
                
                $('#phrase_' + blockID).attr('class', response.block.color)
                $('#typeTranslate_'+blockID).attr('class', response.block.icon).css('display', 'block').html(response.block.typeTranslate)
                $('#dDatetime_'+blockID).attr('datetime', response.block.datetime).html(response.block.date)
            }
        });
    })
    
    $('.go_robot').click(function(){
        var id = $(this).attr('data-id')
        var ob = $(this)
        
        if ( ob.hasClass('isLinkMoreMenu') )
            var url = "/account/robot/" + id
        else
            var url = "/account/getTextFromRobot/" + id
        
        $('#order_'+id).attr('data-type', 1);
        $.ajax({
            url     : url,
            type    : 'post',
            dataType: 'json',
            cache   : false,
            success : function(res)
            {
                $('#order_'+id).val(res.text).css('height', '50px')
                if ( ob.hasClass('isLinkMoreMenu') )
                  {
                    toastr.success(res.message)
                  }
            }
        });
    })
    
    $('.paginationAjax a').click(function(e){
        loadPhrases($(this).attr('href').split('page=')[1]);
        e.preventDefault();
    });
    
    $('.phrases__control').each(function () {
        Slick($(this));
    });
    
    $('.phrases__item-col_translate').each(function() {
        EditText($(this));
    });

    $('.phrases__item-field').each(function() {
        EditComments($(this));
    });


    /*
     |------------------------------------------------------------
     | Инициализация плагина
     |------------------------------------------------------------
     */
    // $(document).account();

    $('#search_page').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: '/account/ajaxRenderingTitlePages',
                method: 'post',
                dataType: 'json',
                data: {
                    name: request.term,
                    site_id: $('#site-list').children('option:selected').val().substr($('#site-list').children('option:selected').val().lastIndexOf('/') + 1),
                    language_id: $('[name="filter[languageID]"]:checked').val(),
                    tab: getCurentTab(),
                    name_none: getNameNone()
                },
                success: function (data) {
                    response($.map(data.blocks, function(item){
                        return item.url;
                    }));
                }
            });
        },
        minLength: 3,
        select: function (event, ui) {
            $('#block_page_title').addClass('bordered');
            $('#block_page_title').append('<div class="selected_for_title_item bordered">' + ui.item.value + '<span class="remove_item">✕</span></div>');
            $(document).on('click', '.remove_item', removeItemPageName)
            addBlocksPages(ui.item.value);
            // console.log(ui);
        }
    });

    /*
     |------------------------------------------------------------
     | Инициализация плагина Autocomplete jQuery UI
     |------------------------------------------------------------
     */
}
addBlocksPages = function (value) {
    var data = {
        name: value,
        site_id: $('#site-list').children('option:selected').val().substr($('#site-list').children('option:selected').val().lastIndexOf('/') + 1),
        language_id: $('[name="filter[languageID]"]:checked').val(),
        tab: getCurentTab(),
        name_none: getNameNone()
    }
    $.ajax({
        url: '/account/ajaxRenderingBlocksPages',
        method: 'post',
        dataType: 'json',
        data: data,
        beforeSend: startLoader(),
        success: function (data) {
            if (data.success) {
                stopLoader()
            }
            if (data.html != '') {
                $('#renderPhrases').html(data.html);
            }
        }
    });
    console.log(data);
}
removeItemPageName = function () {
    $('.remove_item').on('click', function () {
        // console.log(123);
        var obj = $(this);
        $(this).parent('.selected_for_title_item').remove();
        onRemoveClassBordered();
    })
}
onRemoveClassBordered = function () {
    var count = $('#block_page_title').children().length;
    if (Number(count) === 0) {
        $('#block_page_title').removeClass('bordered');
    }
}
getNameNone = function () {
    var ret_data = '',
    none_name_block = $('#block_page_title').children('.selected_for_title_item');
    $.each(none_name_block, function (i, e) {
        ret_data += $(this).text().trim().replace('✕', '') + ','
    });
    return ret_data.slice(0, -1);
}

preloadLoader = function(url)
{
    var _img = new Image();
    _img.src = url;
}

getCurentTab = function()
{
    var active_tab = '';
    $('.tabs__links').find('a').each(function(){ if ($(this).hasClass('active')) active_tab = $(this).attr('id') })
    
    return active_tab
}

setArchive = function(id)
{
    $.ajax({
        url         : "/account/setArchive",
        type        : 'post',
        data        : {id: id},
        dataType    : 'json',
        success     : function(res)
        {
            toastr.success(res.message)
            setNewStats(res.stats)
            $('#phrase_'+id).remove();
        }
    })
}

loadPhrases = function(page)
{
    var page  = !page ? 0 : page
    var data  = $('.site__aside-filter').find('input[type=radio]').serialize();
        data += '&tab='+getCurentTab()
        data += '&page='+page
    
    $.ajax({
        url         : "/account/ajaxPhraseRender",
        type        : 'post',
        data        : data,
        dataType    : 'json',
        beforeSend  : startLoader,
        success     : function(phrases)
        {
            setNewStats(phrases.info.stats)
            stopLoader()
            $('#renderPhrases').html(phrases.html).promise().done(setEventInContent)
        }
    })
}

setNewStats = function(stats)
{
    var total_cc = 0;
    
    $('#stNotTranslate').html(stats.not_translate)
    $('#stInTranslate').html(stats.in_translate)
    $('#stPublish').html(stats.publish)
    
    $.each( stats.proc, function(i, obj) {
        $('#lang_proc_'+i).html(obj + '%')
    });
    
    $.each( stats.menu, function(i, obj) {
        total_cc += obj
        $('#cc_id_'+i).html(obj)
    });
    
    $('#cc_all').html(total_cc)
}

startLoader = function()
{
    $('#renderPhrases').empty().html('<div style="text-align: center;"><img src="/assets/img/account/loader.gif" /></div>')
}

stopLoader  = function()
{
   $('#renderPhrases').empty() 
}

setStatusBlock = function(status)
{
    var data = {status: status, ids: []}
    $(".checkboxPhrase:checked").each(function(){
        data['ids'].push($(this).val());
    })
    
    $.ajax({
        url     : "/account/setStatusBlock",
        type    : 'post',
        dataType: 'json',
        data    : data,
        success : function(res)
        {
            if ( status == 2 )
                $.each( data['ids'], function(i, id) {
                    $('#phrase_'+id).remove()
                });
            
            toastr.success(res.message)
            setNewStats(res.stats)
        }
    });
}

setFilterShow = function(typeViewID)
{
    $.ajax({
        url     : "/account/setTypeView",
        type    : 'post',
        data    : {typeViewID: typeViewID},
        success : function()
        {
            $('#setViewTypeID_1, #setViewTypeID_2').removeClass('active')
            $('#setViewTypeID_' + typeViewID).addClass('active')
            
            loadPhrases()
        }
    });
}

markHandTranslate = function(id, save)
{
    $.ajax({
        url     : "/account/markHandTranslate" + id,
        type    : 'post',
        success : function()
        {
            alert('Готово')
        }
    });
}