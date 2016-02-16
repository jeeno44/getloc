$(function(){

    $('.tabs').each(function() {
        Tabs($(this));
    });

    $('.phrases__item-col_translate').each(function() {
        EditText($(this));
    });

    $('.phrases__item-field').each(function() {
        EditComments($(this));
    });

    $('.site__aside-filter').each(function() {
        Accordion($(this));
    });

    $('.phrases__item-controls-menu').each(function() {
        SubMenu($(this));
    });

    $('.menu').each(function () {
        mobileMenu($(this));
    });

    $('.btn-lock').each(function () {
        BtnLock($(this));
    });

    $('.site__aside-slick').each(function () {
        Slick($(this));
    });

    $('.phrases__control').each(function () {
        Slick($(this));
    });

    $(document).bind('click',function(e){
        if ($(e.target).closest('.menu').length == 0){
            $('.menu__icon').removeClass('close-menu');
            $('.menu').removeClass('open-menu');
        }
    });

} );

var Slick = function(obj)  {

    //private properties
    var _obj = obj,
        _window = $(window),
        _objWidth = _obj.innerWidth(),
        _start  = _obj.offset().top;

    //private methods
    var _addEvents = function() {

            _window.on({
                scroll: function () {

                    _navigation();

                }
            });

        },

         _navigation = function(){

             var scrolling = $(window).scrollTop();

             _obj.css({
                 'width': _objWidth + 2
             });

             if (scrolling > _start) {

                 _obj.addClass('fix')

             }else{

                 _obj.removeClass('fix')

             }

        },

        _init = function() {
            _addEvents();
        };

    //public properties

    //public methods

    _init();
};

var SubMenu = function(obj)  {

    //private properties
    var _obj = obj;

    //private methods
    var _addEvents = function() {

            _obj.on({
                click: function () {

                    $('.phrases__item-controls-menu').not($(this)).removeClass('active');
                    _obj.toggleClass('active');

                    if (event.stopPropagation) {
                        event.stopPropagation();
                    } else {
                        event.cancelBubble = true;
                    }
                }
            });
            $('body').click(function(e){

                var elem=$(e.target);

                _obj.removeClass('active')

            });

        },

        _init = function() {
            _addEvents();
        };

    //public properties

    //public methods

    _init();
};

var EditComments = function(obj) {

    //private properties
    var _obj = obj,
        _btnsWrap = _obj.find('.phrases__item-col-btns'),
        _cancelBtn = _btnsWrap.find('.cancel'),
        _inputField = _obj.find('input');

    //private methods
    var _addEvents = function() {

            _obj.on({
                click: function () {
                    _obj.addClass('active');
                    _btnsWrap.slideDown(300);
                    _fieldVal = _inputField.val();
                }
            });

            _cancelBtn.on({
                click: function () {
                    _inputField.val(_fieldVal);

                    if (!_inputField.val() == 0) {
                        _obj.removeClass('active');
                    }
                    _btnsWrap.slideUp(300);

                    return false
                }
            });

            _obj.on({
                submit: function () {
                    _obj.removeClass('active');
                    _btnsWrap.slideUp(300);

                    return false
                }
            });

        },
        _checkVal = function () {

            if (_inputField.val() == 0) {

                _obj.addClass('active');

            }

        },
        _init = function() {
            _addEvents();
            _checkVal();
        };

    //public properties

    //public methods

    _init();
};

var EditText = function(obj) {

    //private properties
    var _obj = obj,
        _textArea = _obj.find('textarea'),
        _textAreaVal = _textArea.val(),
        _btnsWrap = _obj.find('.phrases__item-col-btns'),
        _cancelBtn = _obj.find('.cancel');

    //private methods
    var _addEvents = function() {

            _textArea.on({
                click: function () {

                    _textArea.removeAttr('readonly');
                    _obj.addClass('active');
                    _btnsWrap.slideDown(300);

                }
            });

            _cancelBtn.on({
                click: function () {

                    _obj.removeClass('active');
                    _textArea.val(_textAreaVal);
                    _textArea.attr('readonly', 'readonly');
                    _btnsWrap.slideUp(300);

                    return false
                }
            });

            _obj.on({
                submit: function () {
                    _obj.removeClass('active');
                    _btnsWrap.slideUp(300);
                    return false
                }
            });
        },

        _setHeight = function () {

            var hiddenDiv = null,
                content = null;

            if (!$('.hidden').length) {

                hiddenDiv = $(document.createElement('div'));
                $('body').append(hiddenDiv);
                hiddenDiv.addClass('hidden');

            }

            content = _textArea.val();

            hiddenDiv.html(content);

            _textArea.css('height', hiddenDiv.innerHeight());

            hiddenDiv.remove();

        },
        _init = function() {
            _addEvents();
            _setHeight();
        };

    //public properties

    //public methods

    _init();
};

var Accordion = function(obj) {

    //private properties
    var _obj = obj,
        _btn = _obj.children( ' span ' ),
        _content = _obj.children( ' div ' );

    //private methods
    var _addEvents = function() {
            _btn.on({
                click: function () {

                    if (_content.is(' :visible ')) {
                        _content.slideUp(300);
                        _btn.removeClass( ' active ' )
                    }else{
                        _content.slideDown(300);
                        _btn.addClass( ' active ' )
                    }

                }
            });
        },
        _init = function() {
            _addEvents();
        };

    //public properties

    //public methods

    _init();
};

var Tabs = function(obj) {

    //private properties
    var _obj = obj,
        _tabs = _obj.find('.tabs__links > a'),
        _wraps = _obj.find('.tabs__content > div'),
        _i = 0;

    //private methods
    var _addEvents = function() {
            showPages = function(i) {
                _wraps.hide().removeClass("active");
                _wraps.eq(i).show(100).addClass('active');
                _tabs.removeClass("active");
                _tabs.eq(i).addClass("active");
            };

            showPages(0);

            _tabs.each(function(index, element) {
                $(element).attr("data-page", _i);
                _i++;
            });

            _tabs.click(function() {
                showPages(parseInt($(this).attr("data-page")));
            });
        },
        _init = function() {
            _addEvents();
        };

    //public properties

    //public methods

    _init();
};

var mobileMenu = function (obj) {
    //private properties
    var _obj = obj,
        _menu = $('.menu'),
        _openBtn = $('.menu__icon');

    //private methods
    var _addEvents = function () {
            _openBtn.on({
                click: function () {
                    console.log('ddd');
                    if (_openBtn.hasClass('close-menu')){
                        _openBtn.removeClass('close-menu');
                        _obj.removeClass('open-menu');
                    } else {
                        _openBtn.addClass('close-menu');
                        _obj.addClass('open-menu');
                        _menu.addClass('mobile-menu');
                    }
                }
            });
        },
        _init = function () {
            _addEvents();
        };

    //public properties

    //public methods

    _init();
};

var BtnLock = function(obj)  {

    //private properties
    var _obj = obj;

    //private methods
    var _addEvents = function() {

            _obj.on({
                'click': function(){
                    if (!($(this).hasClass('btn-lock_on'))){
                        $(this).addClass('btn-lock_on')
                    } else {
                        $(this).removeClass('btn-lock_on')
                    }

                    if ($(this).hasClass('control__btn-lock')){

                        var _father = $(this).parents('.language__item');

                        if (_father.hasClass('language_inactive')){
                            _father.addClass('language_animate');
                            setTimeout(function(){
                                _father.removeClass('language_inactive');
                                _father.removeClass('language_animate');
                            }, 300)
                        } else {
                            _father.addClass('language_animate');
                            setTimeout(function(){
                                _father.addClass('language_inactive');
                                _father.removeClass('language_animate');
                            }, 300)
                        }
                    }
                }
            });

        },

        _init = function() {
            _addEvents();
        };

    //public properties

    //public methods

    _init();
};
