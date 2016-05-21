(function(){
    'use strict';

    $( function() {
        
        $.each( $( '.search-pages' ), function(){
            new Autocomplete( $( this ) );
        } );
        
    } );

    var Autocomplete = function( obj )  {

        //private properties
        var _obj = obj,
            _inputSearch = _obj.find( '.search-pages__input' ),
            _chosenWrap = _obj.find( '.search-pages__chosen'),
            _body = $( 'body' ),
            _request = new XMLHttpRequest(),
            _suggestSelected = 0,
            _valueInput,
            _countItems;

        //private methods

        var _addEvents = function() {

                _inputSearch.on( {
                    'keyup': function( I ) {
                        switch( I.keyCode ) {
                            case 13:
                                $( '.search-pages__result' ).remove();
                                break;
                            case 32:
                            case 27:
                            case 38:
                            case 40:
                                break;
                            default:
                                var count = 0;
                                _valueInput = $( this ).val();

                                if( _valueInput.length > 0 ) {
                                    _ajaxRequest( $( this ), _valueInput.length );
                                } else {
                                    if( $( this ).val() == '' ){
                                        $( '.search-pages__result' ).remove();
                                        _suggestSelected = 0;
                                    }
                                }
                                break;
                        }

                    },
                    'keydown': function( I ){
                        switch( I.keyCode ) {
                            case 27:
                                $( '.search-pages__result' ).remove();
                                _suggestSelected = 0;
                                return false;
                                break;
                            case 38:
                            case 40:
                                I.preventDefault();
                                if( _countItems > 0 ){
                                    _keyActivate( I.keyCode );
                                    if( _suggestSelected == _countItems ){
                                        _suggestSelected = 0
                                    }
                                }
                                _scrollNiceScroll();
                                break;
                        }
                    }
                } );

                _body.click( function() {
                    $( '.search-pages__result' ).remove();
                    _suggestSelected = 0;
                });

                _body.on(
                    "click",
                    "body",
                    function( event ){
                        event = event || window.event;

                        if ( event.stopPropagation ) {
                            event.stopPropagation();
                        } else {
                            event.cancelBubble = true;
                        }
                    }
                );
                _body.on(
                    "click",
                    ".search-pages__result-item",
                    function() {
                        var curItem = $( this ),
                            curText = curItem.text();
                        _inputSearch.val( curText );
                        $( '.search-pages__result' ).remove();
                        _suggestSelected = 0;
                        _addChosenItems( curText );
                    }
                );
                _body.on(
                    "keydown",
                    ".search-pages",
                    function( I ) {
                        if( I.keyCode == 13 ) {
                            var actItem = $( '.search-pages__result').find( '.active'),
                            _suggestSelected = 0;
                            _addChosenItems( actItem.text() );
                        }
                    }
                );

            },
            _addScroll = function() {
                $( '.search-pages__result' ).niceScroll({
                    cursorcolor:"#ebebeb",
                    cursoropacitymin: "1",
                    cursorborderradius: "5px",
                    cursorborder: "none",
                    cursorwidth: "5px",
                    enablekeyboard: true
                });
            },
            _addChosenItems = function( text ) {

                var item = '<div class="search-pages__chosen-item">\
                                <div>'+ text +'</div>\
                                <a class="search-pages__chosen-delete" href="#"></a>\
                            </div>';

                _chosenWrap.append( item );

                DeleteSearchChosenElements( $( '.search-pages__chosen-item:last-child' ) );

            },
            _ajaxRequest = function( input, n ) {
                var path = _obj.attr( 'data-autocomplite' );
                _request.abort();
                _request = $.ajax( {
                    url: path,
                    data: 'value='+ input.val(),
                    dataType: 'json',
                    timeout: 20000,
                    type: "GET",
                    success: function ( msg ) {
                        var $new_arr = [],
                            count = 0;
                        for ( var key in msg ) {
                            var val = msg[ key ];

                            if ( input[ 0 ].value.length > 0 ) {
                                $new_arr.push( val ) ;
                            }

                        }

                        if( $new_arr.length ){

                            $( '.search__result' ).remove();
                            count = $new_arr.length;

                            var resultStr='<div class="search-pages__result">';
                            for( var i = 0; i <= count - 1; i++ ){

                                resultStr += '<div  class="search-pages__result-item">'+$new_arr[i].caption+'</div>';
                            }
                            resultStr+='</div>';
                            if( !_obj.find( '.search-pages__result' ).length == 1 ) {
                                _obj.append( resultStr );
                            }
                            _countItems = $( '.search-pages__result-item' ).length;

                            setTimeout( function() {
                                _addScroll();
                            }, 1 );

                        }
                    },
                    error: function (XMLHttpRequest) {
                        if (XMLHttpRequest.statusText != "abort") {
                            alert("При попытке отправить сообщение произошла неизвестная ошибка. \n Попробуй еще раз через несколько минут.");
                        }
                    }
                } );

                return false;
            },
            _keyActivate = function( n ){
                $( '.search-pages__result-item' ).eq (_suggestSelected - 1 ).removeClass( 'active' );

                if( n == 40 && _suggestSelected < _countItems){
                    _suggestSelected++;

                } else if( n == 38 && _suggestSelected > 0 ){
                    _suggestSelected--;
                }

                if( _suggestSelected > 0 ){
                    $( '.search-pages__result-item' ).eq( _suggestSelected - 1 ).addClass( 'active' );
                    _inputSearch.val( $( '.search-pages__result-item' ).eq( _suggestSelected - 1 ).text() );
                } else {
                    _inputSearch.val( _valueInput );
                }
            },
            _init = function() {
                _addEvents();
            },
            _scrollNiceScroll = function() {
                if( $( '.search-pages__result-item' ).filter( '.active' ).length ) {
                    if( $( '.search-pages__result-item' ).filter( '.active' ).position().top >= $( '.search-pages__result' ).innerHeight() ) {
                        $( '.search-pages__result' ).getNiceScroll( 0 ).doScrollTop( $( '.search-pages__result-item' ).filter('.active').position().top + $( '.search-pages__result-item' ).filter( '.active' ).innerHeight(), -1 );
                    } else if ( $( '.search-pages__result-item' ).filter( '.active' ).position().top + $( '.search-pages__result-item' ).filter( '.active' ).innerHeight() <= 0 ) {
                        $( '.search-pages__result' ).getNiceScroll( 0 ).doScrollTop( $( '.search-pages__result-item' ).filter('.active').position().top + $( '.search-pages__result-item' ).filter( '.active' ).innerHeight(), 1 );
                    }
                }

            };

        //public properties

        //public methods

        _init();
    };
    
})();

