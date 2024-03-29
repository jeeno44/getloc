$(function(){

    $('.tabs').each(function() {
        new Tabs($(this));
    });

    $.each( $('.new-project__form'), function(){
        //new FormValidation ( $(this) );
    } );

    $('.phrases__item-col_translate').each(function() {
        new EditText($(this));
    });

    $('.phrases__item-field').each(function() {
        new EditComments($(this));
    });

    $('.phrases__item-controls-menu').each(function() {
        new SubMenu($(this));
    });

    $('.menu').each(function () {
        new mobileMenu($(this));
    });

    $('.btn-lock').each(function () {
        new BtnLock($(this));
    });

    $('.site__aside-slick').each(function () {
        new Slick($(this));
    });

    $('.phrases__control').each(function () {
        new Slick($(this));
    });

    $( '.translate-orders' ).each( function () {
        new TranslateOrders( $( this ) );
    } );

    $( '.info-massages' ).each( function () {
        new DeleteNotifications( $( this ) );
    } );

    $( '.search-pages__chosen-item' ).each( function () {
        new DeleteSearchChosenElements( $( this ) );
    } );

    $( '.account-data__change-pass' ).each( function () {
        new AddClassApprove( $( this ) );
    } );

    $( '.site__data-field' ).each( function () {
        new LabelFocus( $( this ) );
    } );

    $( '.accordion' ).each( function () {
        new Accordion( $( this ) );
    } );

    $( document ).bind( 'click', function( e ) {
        if ( $( e.target ).closest( '.menu' ).length == 0 ) {
            $( '.menu__icon' ).removeClass( 'close-menu' );
            $( '.menu' ).removeClass( 'open-menu' );
        }
    });

    $( '.datepicker' ).each( function () {
       $( this ).datepicker();
    } );

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
        _saveBtn = _obj.find('.save_translate'),
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
            
            _saveBtn.on({
                click: function () {
                   _obj.removeClass('active');
                    _textArea.attr('readonly', 'readonly');
                    _btnsWrap.slideUp(300);

                    return false
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

var FormValidation = function (obj) {
    var _obj = obj,
        _action = _obj.find( 'form' ).attr( 'action' ),
        _inputs = _obj.find($("[required]")),
        _select = _obj.find( $("select[required]") );

    var _addEvents = function () {

            _obj.on({
                'submit': function(){

                    $.each( _inputs, function(){

                        var curItem = $(this),
                            curAttr = curItem.attr("type");

                        if ( curAttr == "checkbox" ){
                            var curCheck = this.checked;
                            if ( !curCheck ){
                                curItem.addClass("site__required-error");
                                curItem.closest("fieldset").addClass('error');
                            }

                        }
                        else if ( curItem.is("select") ){

                            if ( !curItem.parents(".site__connection-hide_true").length ){
                                if ( curItem.val() == "0" ){
                                    curItem.closest("fieldset").addClass('error');
                                }
                            }

                        }
                        else if ( curItem.val() == '' ) {

                            if ( !curItem.parents(".site__connection-hide_true").length ){
                                curItem.addClass("site__required-error");
                                curItem.closest("fieldset").addClass('error');
                            }
                        }
                        else if ( curAttr == "email" ){
                            var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
                            if ( pattern.test(curItem.val()) == false ){
                                curItem.addClass("site__required-error");
                                curItem.closest("fieldset").addClass('error');
                            }
                        }

                    } );

                    if(!(_obj.find('.error').length) ){

                        if (_obj.hasClass('new-project__form')) {

                            var selectsVal = [];

                            $.each( $('.discount__selects-language select'), function(i){
                                selectsVal[i] = this.value;
                            } );

                            $.ajax({
                                url: _action,
                                dataType: 'html',
                                timeout: 20000,
                                type: "POST",
                                data: {
                                    name: $('#name-project').val(),
                                    url: $('#link-project').val(),
                                    check: $('#new-project__check-val').val(),
                                    language: selectsVal
                                },
                                success: function (data) {
                                    console.log(data);
                                    if ($.isNumeric(data)) {
                                        window.location.href = '/account/project-created/' + data;
                                    }
                                },
                                error: function (XMLHttpRequest) {
                                    if (XMLHttpRequest.statusText != "abort") {
                                        alert(XMLHttpRequest.statusText);
                                    }
                                }
                            });
                            return false;
                        }

                    } else {

                        return false;

                    }
                }
            });

            _inputs.on({

                'focus': function(){

                    var curItem = $(this),
                        closest = curItem.closest("fieldset"),
                        innerInputs = closest.find("input");

                    if(closest.hasClass('error')){
                        curItem.removeClass("site__required-error");
                        if ( innerInputs.length > 1 ){
                            if ( !closest.find(".site__required-error").length ){
                                closest.removeClass('error');
                            }
                        } else {
                            closest.removeClass('error');
                        }
                    }

                }

            });

            _select.on({
                change: function(){
                    var curItem = $(this);
                    curItem.closest("fieldset").removeClass('error');
                }
            });

        },
        _init = function () {
            _addEvents();
        };

    _init();
};

var TranslateOrders = function( obj )  {

    //private properties
    var _obj = obj,
        _delBtn = _obj.find( '.translate-orders__del' ),
        _price = _obj.find( '.translate-orders__price span'),
        _totalPrice = _obj.find( '.translate-orders__total-sum span'),
        _input = _obj.find( '.translate-orders__count'),
        _count = 0;

    //private methods
    var _addEvents = function() {

            _delBtn.on( {
                'click': function() {
                    var curItem = $( this ),
                        parent = curItem.parents( '.translate-orders__item' );

                    parent.addClass( 'hidden' );

                    setTimeout( function() {
                        parent.remove();
                        _setTotalPrice();
                    }, 500 );


                    return false;
                }
            } );
        },
        _setTotalPrice = function() {
            _count = 0;
            _price = _obj.find( '.translate-orders__price span');

            _price.each( function() {
                _count += parseInt( $(this).text() );

            } );

            _totalPrice.html( _count );

            _writeTotalPriceInForm();
        },
        _writeTotalPriceInForm = function() {
            _input.val( _count );
        },
        _init = function() {
            _addEvents();
            _setTotalPrice();
        };

    //public properties

    //public methods

    _init();
};

var DeleteNotifications = function( obj )  {

    //private properties
    var _obj = obj,
        _items = _obj.find( '.info-massages__item' );

    //private methods
    var _addEvents = function() {

            _items.on( {
                'click': function() {
                    var curItem = $( this );

                    curItem.remove();

                    return false;
                }
            } );
        },
        _init = function() {
            _addEvents();
        };

    //public properties

    //public methods

    _init();
};

var DeleteSearchChosenElements = function( obj )  {

    //private properties
    var _obj = obj,
        _btnDel = _obj.find( '.search-pages__chosen-delete' );

    //private methods
    var _addEvents = function() {

            _btnDel.on( {
                'click': function() {
                    var curItem = $( this),
                        parent = curItem.parent('.search-pages__chosen-item');

                    parent.remove();
                    if (typeof loadPhrases !== "undefined") {
                        loadPhrases();
                    }
                    if (typeof loadImages !== "undefined") {
                        loadImages();
                    }
                    if (typeof loadDocs !== "undefined") {
                        loadDocs();
                    }
                    return false;
                }
            } );
        },
        _init = function() {
            _addEvents();
        };

    //public properties

    //public methods

    _init();
};

var AddClassApprove = function( obj )  {

    //private properties
    var _obj = obj,
        _inputPass1 = _obj.find( '.new-pass' ),
        _inputPass2 = _obj.find( '.repeat-pass' );

    //private methods

    var _addEvents = function() {

            _inputPass2.on( {
                'keyup': function() {

                    if( _inputPass2.val() == _inputPass1.val() ) {

                        _inputPass1.addClass( 'site__input_approve' );
                        _inputPass2.addClass( 'site__input_approve' );

                    } else {
                        _inputPass1.removeClass( 'site__input_approve' );
                        _inputPass2.removeClass( 'site__input_approve' );
                    }

                    return false;
                }
            } );
        },
        _init = function() {
            _addEvents();
        };

    //public properties

    //public methods

    _init();
};

var LabelFocus = function( obj )  {

    //private properties
    var _obj = obj,
        _input = _obj.find( '.site__input' ),
        _label = _obj.find( '.site__label' );

    //private methods

    var _addEvents = function() {

            _input.on( {
                'focusin': function() {

                    _label.addClass( 'focus' );

                    return false;
                },
                'focusout': function() {

                    _label.removeClass( 'focus' );

                    return false;
                }
            } );
        },
        _init = function() {
            _addEvents();
        };

    //public properties

    //public methods

    _init();
};

var Accordion = function( obj )  {

    //private properties
    var _obj = obj,
        _btn = _obj.find( '.accordion__head' ),
        _content = _obj.find( '.accordion__content'),
        _scroll;

    //private methods

    var _addEvents = function() {

            _btn.on( {
                click: function() {
                    var curItem = $( this ),
                        contentNext = curItem.next();

                    if( curItem.hasClass( 'active' ) ) {
                        curItem.removeClass( 'active' );
                        contentNext.slideUp();
                    } else {
                        _btn.removeClass( 'active' );
                        _content.slideUp();
                        curItem.addClass( 'active' );
                        contentNext.slideDown();

                        //setTimeout( function() {
                        //    if( contentNext.hasClass( 'translate-set__content' ) ) {
                        //        _addScroll( contentNext );
                        //    }
                        //},300 );


                    }

                    return false;
                }
            } )
        },
        _addScroll = function( elem ) {

            _scroll = elem.niceScroll( {
                cursorcolor:"#ebebeb",
                cursoropacitymin: "1",
                cursorborderradius: "5px",
                cursorborder: "none",
                cursorwidth: "5px"
            } );

        },
        _init = function() {
            _addEvents();
        };

    //public properties

    //public methods

    _init();
};