$(function(){
    
    preloadLoader('/assets/img/account/loader.gif')

    /*
     |------------------------------------------------------------
     | Прячем таб без перевода
     |------------------------------------------------------------
     */
    hideTabNotTranslated();

    /**
    |------------------------------------------------------------
    | События
    |------------------------------------------------------------
    */
    eventAccount();

    
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
    });


})
eventAccount = function () {

    /**
    |------------------------------------------------------------
    | Поиск по названию страницы
    |------------------------------------------------------------
    */
    autoCompletePages();


    $('.disable_display_phrase').on('click', function (e) {
        e.preventDefault();
        disableDisplayPhrase($(this));
    });

    $('.search_language').on('click', function (e) {
        e.preventDefault();
        var data = {
            href: $(this).attr('href'),
            language_id: $(this).closest('.language__links').siblings('.language__control').find('.turnLang').attr('data-langid')
        };
        var link = data.href + '?language_id=' + data.language_id;
        location.href = link;
        // console.log(link);
    });

    $('#checkboxPhraseInOrder').on('click', function () {
        loadPhrases();
    });

    $('.button_search_text').on('click', function (e) {
        e.preventDefault();
        loadPhrases();
    });

    $('.button_date_filter').on('click', function (e) {
        e.preventDefault();
        loadPhrases();
    });

    pagesDisable();

    goToPage();

    orderAddDel();

    checkOrderingTranslation();

    orderTranslate();

    selectAllOrder();

    removeItemPageName()

}

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
    // $('.pagination').find('a').on('click', function (e) {
    //     e.preventDefault()
    //     console.log(123456);
    // })
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



}
disableDisplayPhrase = function (obj) {
    var data = {
        translates_id: obj.closest('.phrases__item').attr('id').split('_').pop(),
        site_id: $('#site-list').children('option:selected').val().substr($('#site-list').children('option:selected').val().lastIndexOf('/') + 1),
        language_id: $('[name="filter[languageID]"]:checked').val()
    };
    $.ajax({
        url         : "/account/disableDisplayPhrase",
        type        : 'post',
        data        : data,
        dataType    : 'json',
        success     : function(data)
        {
            if (data.success) {
                toastr.success(data.message)
                setNewStats(data.stats)
                obj.closest('.phrases__item').remove();
            } else {
                toastr.error(data.message)
            }
            console.log(data);
            // $('#phrase_'+id).remove();
        }
    })

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
    var page  = !page ? 0 : page,
        view_type = $('#setViewTypeID_1').hasClass('active') ? 1 : 2,
        phrase_in_order = $('#checkboxPhraseInOrder').prop('checked') ? 1 : 0 ,
        min_date = $('.date_filter_start').val() != '' ? $('.date_filter_start').val() : 0,
        max_date = $('.date_filter_end').val() != '' ? $('.date_filter_end').val() : 0,
        data  = $('.site__aside-filter').find('input[type=radio]').serialize();
        data += '&tab='+getCurentTab()
        data += '&page='+page
        data += '&site_id='+$('#site-list').children('option:selected').val().substr($('#site-list').children('option:selected').val().lastIndexOf('/') + 1)
        if (getNameNone() != '') {
            data += '&name_none='+getNameNone()
        }
        if ($('.search_text').val() != '') {
            data += '&search_text='+$('.search_text').val();
        }
        data += '&phrase_in_order=' + phrase_in_order;
        data += '&view_type='+view_type;
        data += '&min_date='+min_date;
        data += '&max_date='+max_date;
        data += '&pathname='+window.location.pathname;


    /*
    |------------------------------------------------------------
    | TODO: удалить после тестирования
    |------------------------------------------------------------
    */
    console.log(data);

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
            // eventAccount()
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

hideTabNotTranslated = function () {

    /*
     |------------------------------------------------------------
     | Прячем таб без перевода
     |------------------------------------------------------------
     */
    var tab_not_translated = $('#tab_not_translated');
    var count = tab_not_translated.find('#stNotTranslate').text();
    if (Number(count) === 0) {
        tab_not_translated.css({display: 'none'}).removeClass('active').next().addClass('active').prev('#stNotTranslate');
        $(document).on('click', '.remove_item', removeItemPageName);
        loadPhrases();
        // $(document).on('click', '.remove_item', setEventInContent());
    }
}

/** -------------------- Start.translation to order -------------------- */

orderTranslate = function () {

    $('#orderTranslate').on('click', function (e) {
        e.preventDefault()
        var data_id = {}, count = 0;

        $.each($('.nice-check').find('.checkbox_ordering_translation'), function (i, e) {
            data_id[count] = {
                id: $(e).val(),
                check: $(e).prop('checked') ? 1 : 0
            };
            count ++;
        });
        if (count > 0) {
            var data = {
                data_id: data_id
            };
            $.post('/account/orderingTranslation', data, function (obj) {
                var obj_data = $.parseJSON(obj);
                // console.log(obj_data);
                $('.phrases_in_order').find('.phrasesCount').text(obj_data.phrasesInOrder);
                $('#phrases_in_order').find('.phrasesCount').text(obj_data.phrasesInOrder);
                $('#cost_order').find('.costCount').text(obj_data.costOrder);
            });
        }
    });
}

addOrder = function (obj) {
    $('#ordering_translation_'+obj.attr('data-id')).prop('checked', true);
    $('#ordering_translation_'+obj.attr('data-id')).next('label').text('Отменить выбор фразы в заказ');
    obj.removeClass('addOrder').addClass('delOrder').text('Убрать из заказа');
    var data_id = {}, count = 0;
    data_id[count] = {
        id: obj.attr('data-id'),
        check: $('#ordering_translation_'+obj.attr('data-id')).prop('checked') ? 1 : 0
    };
    // console.log(data_id);
    var data = {
        data_id: data_id
    };
    $.post('/account/orderingTranslation', data, function (obj_data) {
        var obj_data = $.parseJSON(obj_data);
        // console.log(obj_data);
        $('.phrases_in_order').find('.phrasesCount').text(obj_data.phrasesInOrder);
        $('#phrases_in_order').find('.phrasesCount').text(obj_data.phrasesInOrder);
        $('#cost_order').find('.costCount').text(obj_data.costOrder);
    });
}

delOrder = function (obj) {
    $('#ordering_translation_'+obj.attr('data-id')).prop('checked', false);
    $('#ordering_translation_'+obj.attr('data-id')).next('label').text('Выбрать фразу в заказ');
    obj.removeClass('delOrder').addClass('addOrder').text('Добавить в заказ');
    var data_id = {}, count = 0, $this = $(this);
    data_id[count] = {
        id: obj.attr('data-id'),
        check: $('#ordering_translation_'+obj.attr('data-id')).prop('checked') ? 1 : 0
    };
    // console.log(data_id);
    var data = {
        data_id: data_id
    };
    $.post('/account/orderingTranslation', data, function (obj_data) {
        var obj_data = $.parseJSON(obj_data);
        // console.log(obj_data);
        $('.phrases_in_order').find('.phrasesCount').text(obj_data.phrasesInOrder);
        $('#phrases_in_order').find('.phrasesCount').text(obj_data.phrasesInOrder);
        $('#cost_order').find('.costCount').text(obj_data.costOrder);
    });
}

selectAllOrder = function () {

    $('.select_all').on('click', function () {
        if ($(this).prop('checked')) {
            $.each($('.nice-check').find('.checkbox_ordering_translation'), function (i, e) {
                $(e).prop('checked', true);
            });
        } else {
            $.each($('.nice-check').find('.checkbox_ordering_translation'), function (i, e) {
                $(e).prop('checked', false);
            });
        }
    });
}

checkOrderingTranslation = function () {

    $('.checkbox_ordering_translation').on('change', function () {
        if ($(this).prop('checked')) {
            $(this).next('label').text('Отменить выбор фразы в заказ');
        } else {
            $(this).next('label').text('Выбрать фразу в заказ');
        }
    });
}

orderAddDel = function () {
    var phrases_icm = $('.phrases__item-controls-menu');
    phrases_icm.on('click', '.addOrder',  function (e) {
        e.preventDefault();
        addOrder($(this))
    });

    phrases_icm.on('click', '.delOrder',  function (e) {
        e.preventDefault();
        delOrder($(this))
    });
}

/** -------------------- End.translation to order -------------------- */

/** -------------------- Start.Disable pages -------------------- */

pagesDisable = function () {
    $('.pages_disable').on('click', function () {
        // var url = $(this).parent().html();
        var data = {
            url: $(this).siblings('a.link_pages').text(),
            check: $(this).prop('checked') ? 1 : 0
        };
        $.post('/account/pagesDisable', data, function (obj) {
            console.log(obj);
        });
    });
}

/** -------------------- End.Disable pages -------------------- */

/** -------------------- Start.Go to page -------------------- */

    goToPage = function () {
        $('.link_pages').on('click', function (e) {
            e.preventDefault();
            var data = {
                url: $(this).text(),
                href: $(this).attr('href'),
                check: $(this).siblings('.pages_disable').prop('checked') ? 1 : 0
            };
            if (data.check) {
                $.post('/account/locationPhrase', data, function (obj) {
                    var obj = $.parseJSON(obj);
                    console.log(obj);
                    if (obj.success) {
                        location.href = location.origin + data.href;
                        console.log(location);
                    }
                })
            }
        });
    }

/** -------------------- End.Go to page -------------------- */

/** -------------------- Start.Autocomplete -------------------- */

    autoCompletePages = function () {

        /*
         |------------------------------------------------------------
         | Инициализация плагина
         |------------------------------------------------------------
         */
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
                var block_page_title = $('#block_page_title');
                block_page_title.addClass('bordered');
                block_page_title.append('<div class="selected_for_title_item bordered">' + ui.item.value + '<span class="remove_item">✕</span></div>');
                // block_page_title.on('click', '.remove_item', removeItemPageName);
                loadPhrases();
                console.log(event);
                $('#search_page').delay(5000).val('');
                // $('')
                setTimeout(
                    function () {
                        $('#search_page').val('');
                    }, 2000
                )
            }
        });
    }

    removeItemPageName = function () {
        $('#block_page_title').on('click', '.remove_item', function () {
            // console.log(123);
            var obj = $(this);
            $(this).parent('.selected_for_title_item').remove();
            onRemoveClassBordered();
            loadPhrases();
        })
    }

    onRemoveClassBordered = function () {
        var count = $('#block_page_title').children().length;
        if (Number(count) === 0) {
            $('#block_page_title').removeClass('bordered');
        }
    }

/** -------------------- End.Autocomplete -------------------- */