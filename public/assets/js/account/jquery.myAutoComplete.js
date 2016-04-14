
(function($) {
    var settings, obj,
    methods = {
        init: function (options) {
            obj = $( this );
            settings = $.extend({
                theme: '', // '',  'default'
                urlRequest: '',
                titleBlockEl: '',
                dataBlockEl: '',
                paginationEl: '',
                customObjData: {},
                method: '', // post, get
                dataType: 'json'
            }, options);

            console.log(obj);
            
            if (settings.theme === 'default') {
                methods.addingStyles();
            }

            methods.eventListener()

        },
        eventListener: function () {
            obj.on('input', function (e) {
                var length = $(this).val().length;
                if (length > 2) {
                    var data = methods.getData($(this));
                    methods.ajax(data);

                    console.log(data);
                }
            });
            $('.found_for_title_wrap').find('.found_for_title_item').on('click', function () {
                var title = $(this).text();
                var titleBlock = $('<div/>', {
                    stile: "position: relative;",
                    text: title,
                    class: 'found_for_title_item'
                });
                var close = $('<div/>', {
                    class: 'close',
                    text: '✕',
                    stile: "position: absolute; top: 0; right:0;"
                });
                titleBlock.append(close);
                $('.selected_for_title').append(titleBlock);
                $('.selected_for_title').css({border: "solid 1px #b2b2b2"});
                $(this).detach();

            })
        },
        getData: function (obj) {
            $.extend(settings.customObjData, {
                value: obj.val()
            });
            return settings.customObjData;
        },
        addingStyles: function () {
            obj.css({
                width: "100%",
                height: "40px",
                border: "none",
                "border-radius": "5px",
                "font-size": "14px",
                padding: "0 10px",
                color: "#b2b2b2",
                "margin-bottom": "10px"
            }).css({border: "1px solid #e6e6e6"});
            console.log(settings.theme);
        },
        startLoader: function()
        {
            $(settings.dataBlockEl).empty().html('<div style="text-align: center;"><img src="/assets/img/account/loader.gif" /></div>')
        },
        stopLoader: function()
        {
            $(settings.dataBlockEl).empty()
        },
        ajax: function (data) {
            $.ajax({
                url: settings.urlRequest,
                type: settings.method,
                data: data,
                dataType: settings.dataType,
                beforeSend: methods.startLoader,
                success: function (phrases) {
                    if (phrases.success) {
                        methods.stopLoader()
                    }
                    if (phrases.html != '') {
                        $('.found_for_title_wrap').html(phrases.html);
                        $('.found_for_title_wrap').css({border: "solid 1px #000000"});
                        methods.eventListener();
                    }
                }
            });
        }

    };

    $.fn.myAutoComplete = function(method){
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