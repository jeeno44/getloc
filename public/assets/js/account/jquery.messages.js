$( function() {

    new Messages( {
        class: 'info-massages__item_detected',
        text: 'Обнаружено 120 новых фраз'
    } );

    new Messages( {
        class: 'info-massages__item_opportunity',
        text: 'Появилась возможность перевода еще на 12 иностранных языков'
    } );

    new Messages( {
        class: 'info-massages__item_important',
        text: 'Срок действия вашего тарифа подошел к концу'
    } );

    new Messages( {
        class: 'info-massages__item_delete',
        text: 'Ваш аккаунт был удалён!'
    } );

} );

var Messages = function( params ) {

    //private properties
    var _class = params.class,
        _text = params.text,
        _siteContent = $( '.site__content'),
        _massageWrap = $( '.info-massages');

    //private methods

    var _addMessage = function() {

            var messageItem = $( '<div class="info-massages__item '+ _class +'">\
                                    '+ _text +'\
                                </div>' );

            if( _massageWrap.length ) {
                _massageWrap.append( messageItem );
            } else {
                var massageWrap = $( '<div class="info-massages"></div>' );
                massageWrap.append( messageItem );
                _siteContent.prepend( massageWrap );
            }

            setTimeout( function() {
                messageItem.addClass( 'hiddenMessage' );
            }, 5000 )

        },
        _init = function() {
            _addMessage();
        };

    //public properties

    //public methods

    _init();
};