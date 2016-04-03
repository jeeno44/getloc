
;(function($) {
    var settings, document, obj,
        // page_auto_complete = $('#input_page_auto_complete'),
        // titleBlockLi = $('li.found_for_title_item'),
        // selected_for_title_wrap = $('div.selected_for_title_wrap'),

    methods = {
        init: function (options) {
            document = $( this );
            settings = $.extend({
                theme: 'default', // '',  'default'
                url: '',
                data: {},
                method: 'post', // post, get
                dataType: 'json',
                success: '',
                filter_page_site_wrap: $('.filter_page_site_wrap'),
                input_page_auto_complete: $('#input_page_auto_complete'),
                selected_for_title_wrap: $('.selected_for_title_wrap'),
                found_for_title_wrap: $('ul.found_for_title_wrap'),
                found_for_title_item: $('.found_for_title_item'),
                titleBlockDiv: '',
                remove_item: ''
        }, options);

            if (settings.theme === 'default') {
                // methods.addingStyles();
            }
            methods.eventListener()

        },
        eventListener: function () {
            $('.input_page_auto_complete').off('input').on('input', function () {
                methods.getDataTitle($(this))
            });
            $('.found_for_title_item').off('click').on('click', function () {
                methods.addDataTitle($(this));
            });
            $('.remove_item').off('click').on('click', function () {
                methods.delDataTitle($(this));
            });
        },
        delDataTitle: function (obj) {
            var wrap = obj.closest('.selected_for_title_wrap');
            $.each(settings.found_for_title_wrap.children(), function (i, e) {
                if (Number($(this).attr('data-page-id')) === Number(obj.parent('.selected_for_title_item').attr('data-page-id'))) {
                    $(this).removeClass('inactive').addClass('found_for_title_item');
                    methods.eventListener();
                }
            });
            obj.parent('.selected_for_title_item').remove();
            if (wrap.children().length === 0) {
                wrap.removeClass('bordered');
            }
        },
        addDataTitle: function (obj) {
            obj.off().addClass('inactive').removeClass('found_for_title_item');
            settings.titleBlockDiv = $('<div/>', {class: 'selected_for_title selected_for_title_item bordered'});
            settings.remove_item = $('<span/>', {class: 'remove_item', text: '✕'});
            settings.titleBlockDiv.append('<span class="remove_item">✕</span>').prepend(obj.text()).attr('data-page-id', obj.attr('data-page-id')).attr('data-site-id', obj.attr('data-site-id'));
            settings.selected_for_title_wrap.addClass('bordered').append(settings.titleBlockDiv);
            methods.eventListener();
            settings.url = '/account/ajaxRenderingBlocksPages';
            settings.data = {
                // value: obj.val(),
                site_id: obj.attr('data-site-id'),
                page_id: obj.attr('data-page-id'),
                language_id: $('[name="filter[languageID]"]:checked').val(),
                tab: getCurentTab()
            };
            // console.log(settings.data);
            settings.success = function (data) {
                if (data.success) {
                    methods.stopLoader()
                }
                if (data.html != '') {
                    $('#renderPhrases').html(data.html);
                }
            };
            methods.ajax(settings.url, settings.method, settings.data, settings.dataType, settings.success);
        },
        getDataTitle: function (obj) {
            var length = obj.val().length;
            if (length > 2) {
                settings.url = '/account/ajaxRenderingTitlePages';
                settings.data = {
                    value: obj.val(),
                    site_id: obj.attr('data-site-id'),
                    language_id: $('[name="filter[languageID]"]:checked').val(),
                    tab: getCurentTab()
                };
                settings.success = function (data) {
                    if (data.success) {
                        methods.stopLoader()
                    }
                    if (data.html != '') {
                        settings.found_for_title_wrap.addClass('bordered').html(data.html);
                        obj.nextAll().remove();
                        settings.filter_page_site_wrap.append(settings.found_for_title_wrap);
                        methods.eventListener();
                    }
                };
                methods.ajax(settings.url, settings.method, settings.data, settings.dataType, settings.success);
            }
        },
        startLoader: function()
        {
            $('#renderPhrases').empty().html('<div style="text-align: center;"><img src="/assets/img/account/loader.gif" /></div>')
        },
        stopLoader: function()
        {
            $('#renderPhrases').empty()
        },
        ajax: function (url, method, data, dataType, success) {
            $.ajax({
                url: url,
                type: method,
                data: data,
                dataType: dataType,
                beforeSend: methods.startLoader,
                success: success
            });
        }
    };

    $.fn.account = function(method){
        // Логика вызова метода
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || ! method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Метод с именем ' +  method + ' не существует для jQuery.myAutoComplete');
        }
    };

})(jQuery);