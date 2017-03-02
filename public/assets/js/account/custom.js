var currentPageNumber = 1;

$(function(){

    $('.btn-actions').click(function (e) {
        $('.dropdown').hide();
        if ($(this).hasClass('opened')) {
            $(this).next().hide();
            $(this).removeClass('opened');
        } else {
            $(this).next().show();
            $(this).addClass('opened');
        }
        e.preventDefault();
    });
    $('.popup').each(function(){
        popups = new Popup($(this));
    });
    $('.select2').select2({
        width: '100%',
        lang: 'ru',
        language: 'ru',
        locale: 'ru'
    });

    preloadLoader('/assets/img/account/loader.gif');
    $('.phrases__item-controls-menu').each(function() {
        SubMenu($(this));
    });

    $('a.find-phrase__clean').click(function (e) {
        $('.search_text').val('');
        $('.find-phrase__go').trigger('click')
        e.preventDefault();
    });
    
    if ($('.flash-message').length >= 1) {
        $('.flash-message').each(function () {
            className = $(this).attr('id');
            text = $(this).text();
            new Messages({class: className,text: text});
        });
    }

    $('.account-menu-parent').click(function (e) {
        if ($(this).hasClass('opened')) {
            $(this).next().slideUp();
            $(this).removeClass('opened');
        } else {
            $(this).next().slideDown();
            $(this).addClass('opened');
        }
        e.preventDefault();
    });
    if ($('.account-menu-item.active').length > 0) {
        $('.account-menu-item.active').parent().show();
        $('.account-menu-item.active').parent().prev().addClass('active');
    }

    /*
     |------------------------------------------------------------
     | Прячем таб без перевода
     |------------------------------------------------------------
     */
    //hideTabNotTranslated();

    /**
    |------------------------------------------------------------
    | События
    |------------------------------------------------------------
    */
    eventAccount();

    setCountItems();

    
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
        if ($(this).attr('id') == 'tab_acrhive') {
            $('#check-all-phrases').hide();
            $('#nopublishing').hide();
            $('#to-archive').hide();
            $('#order-selected-phrases').hide();
            $('#from-archive').show();
        } else {
            $('#check-all-phrases').show();
            $('#nopublishing').show();
            $('#to-archive').show();
            $('#order-selected-phrases').show();
            $('#from-archive').hide();
        }
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

    $('#to-archive').click(function(){
        setArchiveBlock(1)
    })

    $('#from-archive').click(function(){
        setArchiveBlock(0)
    })

    $('#order-selected-phrases').click(function(e){
        setOrderBlock(1);
        e.preventDefault();
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
                new Messages( {
                    class: 'info-massages__item_detected',
                    text: res
                } );
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
                new Messages( {
                    class: 'info-massages__item_detected',
                    text: res
                } );
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

function setCountItems() {
    $('#renderPhrases').on('click', '.count-items', function (e) {
        $('.count-items').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
        loadPhrases();
    })
}

function loadHistory() {
    $('.show-history').on('click', function (e) {
        var id = $(this).attr('data-id');
        var hf = $(this).closest('.phrases__item').find('.history-phrase');
        hf.load('/account/get-history/' + id, function () {
            hf.slideDown();
        });
        e.preventDefault();
    });
    $(document).on('click', '.hide-history', function (e) {
        var hf = $(this).closest('.phrases__item').find('.history-phrase');
        hf.slideUp();
        e.preventDefault();
    });
}

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

    $('.datepicker').on('change', function (e) {
        e.preventDefault();
        loadPhrases();
    });

    pagesDisable();

    // goToPage();

    orderAddDel();

    orderTranslate();

    selectAllOrder();

    removeItemPageName()

    loadHistory();

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
                new Messages( {
                    class: 'info-massages__item_detected',
                    text: response.message
                } );
                setNewStats(response.stats)

                $('#phrase_' + blockID).attr('class', response.block.color)
                $('#typeTranslate_'+blockID).attr('class', response.block.icon).css('display', 'block').html(response.block.typeTranslate)
                $('#dDatetime_'+blockID).attr('datetime', response.block.datetime).html(response.block.date)
                loadPhrases();
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
                $('#order_'+id).empty().val(res.text).css('height', '50px')
                if ( ob.hasClass('isLinkMoreMenu') ) {
                      new Messages( {
                          class: 'info-massages__item_detected',
                          text: res.message
                      } );
                      loadPhrases();
                }
            }
        });
    })
    // $('.pagination').find('a').on('click', function (e) {
    //     e.preventDefault()
    //     console.log(123456);
    // })
    $('.paginationAjax>ul>li>a').click(function(e){
        if (location.pathname !== '/account/pages') {
            currentPageNumber = $(this).attr('href').split('page=')[1];
            loadPhrases($(this).attr('href').split('page=')[1]);
            e.preventDefault();
        }

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

/**
 |------------------------------------------------------------
 | Отключаем/подключаем блок
 |------------------------------------------------------------
 */
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
                new Messages( {
                    class: 'info-massages__item_detected',
                    text: data.message
                } );
                setNewStats(data.stats)
                obj.closest('.phrases__item').remove();
            } else {
                new Messages( {
                    class: 'info-massages__item_delete',
                    text: data.message
                } );
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
            new Messages( {
                class: 'info-massages__item_detected',
                text: res.message
            } );
            loadPhrases();
        }
    })
}

loadPhrases = function(page)
{
    var pageUrls = [];
    if ($('.search-pages__chosen-item').length > 0) {
        $('.search-pages__chosen-item').each(function () {
            var pageUrl = $(this).find('div').text();
            if (pageUrl) {
                pageUrls.push(pageUrl);
            }
        });
    }
    var page  = !page ? 1 : page,
        view_type = $('#setViewTypeID_1').hasClass('active') ? 1 : 2,
        phrase_in_order = $('#checkboxPhraseInOrder').prop('checked') ? 1 : 0 ,
        min_date = $('.date_filter_start').val() != '' ? $('.date_filter_start').val() : 0,
        max_date = $('.date_filter_end').val() != '' ? $('.date_filter_end').val() : 0,
        items_per_page = $('.count-items.active').attr('data-value') ? $('.count-items.active').attr('data-value'): 20,
        data  = $('.site__aside-filter').find('input[type=radio]').serialize();
        data += '&tab='+getCurentTab()
        data += '&page='+currentPageNumber
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
        data += '&items_per_page='+items_per_page;
        data += '&pageUrls='+pageUrls,


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
            ajaxLoadEventInit();
            loadHistory();
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
    $('#renderPhrases').empty().html('<div class="preloader"><img src="/assets/img/account/loader.svg" /></div>')
}

stopLoader  = function()
{
   $('#renderPhrases').empty() 
}

setStatusBlock = function(status)
{
    $('#check').prop('checked', false);
    var data = {status: status, ids: []}
    $("input[name='blocks[]']:checked").each(function(){
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
            
            if ( res.isError ) {
                new Messages({
                    class: 'info-massages__item_delete',
                    text: res.message
                } );
            } else {
                new Messages( {
                    class: 'info-massages__item_detected',
                    text: res.message
                });
            }
            loadPhrases()
        }
    });
}

setOrderBlock = function(order)
{
    $('#check').prop('checked', false);
    var data_id = []; var data = {};
    $("input[name='blocks[]']:checked").each(function(){
        data_id.push({id: $(this).val(), check: order});
    });
    data['data_id'] = data_id;
    $.ajax({
        url     : "/account/orderingTranslation",
        type    : 'post',
        dataType: 'json',
        data    : data,
        success : function(res)
        {
            if (res.isError) {
                new Messages( {
                    class: 'info-massages__item_delete',
                    text: res.message
                });
            } else {
                new Messages( {
                    class: 'info-massages__item_detected',
                    text: res.message
                });
                $('.phrasesCount').text(res.phrasesInOrder);
                $('.costCount').text(res.costOrder);
                if (parseInt(res.phrasesInOrder) > 0) {
                    $('.make-order').show();
                } else {
                    $('.make-order').hide();
                    $('#checkboxPhraseInOrder').prop('checked', false);
                    if ($('#checkboxPhraseInOrder').prop('checked') == false) {
                        //loadPhrases();
                    }
                }
                if($('#checkboxPhraseInOrder').is(':checked')) {
                    //loadPhrases();
                }
                loadPhrases();
            }
        }
    });
}

setArchiveBlock = function(status)
{
    $('#check').prop('checked', false);
    var data = {archive: status, ids: []}
    $("input[name='blocks[]']:checked").each(function(){
        data['ids'].push($(this).val());
    })

    $.ajax({
        url     : "/account/archive-block",
        type    : 'post',
        dataType: 'json',
        data    : data,
        success : function(res)
        {
            if ( res.isError ) {
                new Messages({
                    class: 'info-massages__item_delete',
                    text: res.message
                } );
            } else {
                new Messages( {
                    class: 'info-massages__item_detected',
                    text: res.message
                });
            }
            loadPhrases()
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
        url     : "/account/markHandTranslate/" + id,
        type    : 'post',
        success : function()
        {
            loadPhrases();
            new Messages( {
                class: 'info-massages__item_detected',
                text: 'Перевод помечен, как "ручной"'
            } );
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
        // loadPhrases();
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
                $('.phrasesCount').text(obj_data.phrasesInOrder);
                $('.costCount').text(obj_data.costOrder);
                if (parseInt(obj_data.phrasesInOrder) > 0) {
                    
                } else {
                    
                }
            });
        }
    });
}

addOrder = function (obj) {
    obj.removeClass('addOrder').addClass('delOrder').text('Убрать из заказа');
    var data_id = {}, count = 0;
    data_id[count] = {
        id: obj.attr('data-id'),
        check: 1
    };
    // console.log(data_id);
    var data = {
        data_id: data_id
    };
    $.post('/account/orderingTranslation', data, function (obj_data) {
        var obj_data = $.parseJSON(obj_data);
        $('.phrasesCount').text(obj_data.phrasesInOrder);
        $('.costCount').text(obj_data.costOrder);
        new Messages( {
            class: 'info-massages__item_detected',
            text: 'Фраза добавлена в заказ'
        } );
        if($('#checkboxPhraseInOrder').is(':checked')) {
            //loadPhrases();
        }
        loadPhrases();
    });
}

delOrder = function (obj) {
    obj.removeClass('delOrder').addClass('addOrder').text('Добавить в заказ');
    var data_id = {}, count = 0, $this = $(this);
    data_id[count] = {
        id: obj.attr('data-id'),
        check: 0
    };
    // console.log(data_id);
    var data = {
        data_id: data_id
    };
    $.post('/account/orderingTranslation', data, function (obj_data) {
        var obj_data = $.parseJSON(obj_data);
        $('.phrasesCount').text(obj_data.phrasesInOrder);
        $('.costCount').text(obj_data.costOrder);
        new Messages( {
            class: 'info-massages__item_delete',
            text: 'Фраза удалена из заказа'
        } );
        if (parseInt(obj_data.phrasesInOrder) > 0) {
            $('.make-order').show();
        } else {
            $('.make-order').hide();
            $('#checkboxPhraseInOrder').prop('checked', false);
            if ($('#checkboxPhraseInOrder').prop('checked') == false) {
                //loadPhrases();
            }
        }
        if($('#checkboxPhraseInOrder').is(':checked')) {
            //loadPhrases();
        }
        loadPhrases();
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

checkOrderingTranslation = function () {}

orderAddDel = function () {
    // var phrases_icm = $('.phrases__item-controls-menu');
    $('.addOrder').on('click', function (e) {
        e.preventDefault();
        addOrder($(this))
    });

    $('.delOrder').on('click', function (e) {
        e.preventDefault();
        delOrder($(this))
    });
}

/** -------------------- End.translation to order -------------------- */

/** -------------------- Start.Disable pages -------------------- */

pagesDisable = function () {
    $('.pages_disable').on('click', function () {
        var url = $(this).parent().html();
        console.log(url);
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

    // goToPage = function () {
    //     $('.link_pages').on('click', function (e) {
    //         e.preventDefault();
    //         var data = {
    //             url: $(this).text(),
    //             href: $(this).attr('href'),
    //             check: $(this).siblings('.pages_disable').prop('checked') ? 1 : 0
    //         };
    //         if (data.check) {
    //             $.post('/account/locationPhrase', data, function (obj) {
    //                 var obj = $.parseJSON(obj);
    //                 console.log(obj);
    //                 if (obj.success) {
    //                     location.href = location.origin + data.href;
    //                     console.log(location);
    //                 }
    //             })
    //         }
    //     });
    // }

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

ajaxLoadEventInit = function () {
    // var phrases_icm = $();
    $('.phrases__item').on('click', '.addOrder', function (e) {
        e.preventDefault();
        addOrder($(this))
    });

    $('.phrases__item').on('click', '.delOrder', function (e) {
        e.preventDefault();
        delOrder($(this))
    });
}
var Popup = function( obj ){
    this.popup = obj;
    this.btnShow = $('.popup__open');
    this.btnClose = obj.find( '.popup__close, .popup__cancel' );
    this.wrap = obj.find($('.popup__wrap'));
    this.contents = obj.find($('.popup__content'));
    this.window = $( window );
    this.scrollConteiner = $( 'html' );
    this.timer = setTimeout( function(){},1 );

    this.init();
};
Popup.prototype = {
    init: function(){
        var self = this;
        self.core = self.core();
        self.core.build();
    },
    core: function (){
        var self = this;
        return {
            build: function (){
                self.core.controls();
            },
            controls: function(){

                $('.popup__content').on( 'click','.popup__open', function(){
                    var curItem = $(this);
                    self.contents.css( 'display', '' );
                    self.core.setPopupContent( curItem.attr( 'data-popup' ) );
                    return false;

                    //self.core.show( curItem.attr( 'data-popup' ) );
                    //self.btnClose = self.popup.find(".popup__close");
                    //$('.popup_opened').find('#order-popup__type').val( curItem.attr( 'data-type' ) );
                    //return false;

                });

                $('body').on( 'click','.popup__open', function(){
                    var curItem = $(this),
                        parentDropdown = curItem.parents(".dropdown"),
                        linkDropdown = parentDropdown.find("a[data-toggle=dropdown]");
                    parentDropdown.removeClass("open");
                    linkDropdown.attr("aria-expanded", "false");
                    self.core.show( curItem.attr( 'data-popup' ) );
                    $('.popup_opened').find('#email').focus();
                    self.btnClose = self.popup.find(".popup__close");
                    $('.popup_opened').find('#order-popup__type').val( curItem.attr( 'data-type' ) );
                    return false;
                } );

                self.wrap.on( {
                    click: function( event ){
                        event = event || window.event;

                        if (event.stopPropagation) {
                            event.stopPropagation();
                        } else {
                            event.cancelBubble = true;
                        }
                    }
                } );
                self.popup.on( {
                    click: function(){
                        self.core.hide();
                        return false;
                    }
                } );
                self.btnClose.on( {
                    click: function(){
                        self.core.hide();
                        return false;
                    }
                } );
            },
            hide: function(){
                self.popup.css ({
                    'overflow-y': "hidden"
                });
                self.scrollConteiner.css({
                    paddingRight: 0,
                    'overflow-y': "scroll"
                });
                self.popup.removeClass('popup_opened');
                self.popup.addClass('popup_hide');
                location.hash = '';
                setTimeout( function(){
                    self.popup.removeClass('popup_hide');
                }, 300 );
            },
            getScrollWidth: function (){
                var scrollDiv = document.createElement("div");
                scrollDiv.className = "popup__scrollbar-measure";
                document.body.appendChild(scrollDiv);
                var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
                document.body.removeChild(scrollDiv);
                return scrollbarWidth;
            },
            show: function( className ){

                if ( self.popup.hasClass( 'popup_opened' ) ){
                    self.core.hide();
                }

                if (self.contents.height()+120 > self.window.height()){
                    self.popup.css ({
                        'overflow-y': "scroll"
                    });
                    self.scrollConteiner.css( {
                        'overflow-y': "hidden",
                        paddingRight: 17
                    });
                }
                self.core.setPopupContent( className );
                self.popup.addClass('popup_opened');
                $('.popup_opened').find('#order-popup__name').focus();
            },
            setPopupContent: function( className ){
                self.contents = self.popup.find('.popup__content');
                var curContent = self.contents.filter( '.popup__' + className );
                self.contents.css( { display: 'none' } );
                curContent.css( { display: 'block' } );
            }

        };
    }
};