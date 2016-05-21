$( function() {

    $( '.widget-settings' ).each( function () {
        new Widget( $( this ) );
    } );

} );

var Widget = function( obj ) {

    //private properties
    var _obj = obj,
        _widget = _obj.find( '.widget__menu'),
        _widgetClass = _widget.attr( 'class' ),
        _inputHiddenClasses = _obj.find( '.widget-classes' ),
        _inputHiddenColors = _obj.find( '.widget-colors' ),
        _itemColors = _obj.find( '.widget-settings__colors-item' ),
        _btnControls = _obj.find( '.widget-settings__controls-btn'),
        _settings = _obj.find( '.widget-settings__controls-settings'),
        _colors = _obj.find( '.widget-settings__colors'),
        _classesInput,
        _colorsInput;

    //private methods

    var _addColorPicker = function() {

            _itemColors.each( function () {
                $( this ).colorpicker(  );
            } );

        },
        _addEvents = function() {

            _settings.on( {
                click: function() {
                    var curItem = $( this );

                    if( curItem.hasClass( 'opened' ) ) {
                        curItem.removeClass( 'opened' );
                        _colors.slideUp();
                    } else {
                        curItem.addClass( 'opened' );
                        _colors.slideDown();
                    }

                    return false;
                }
            } );

            _btnControls.on( {
                click: function() {

                    _classesInput = '';

                    var curItem = $( this),
                        curClass = curItem.data( 'class'),
                        parent = curItem.parent( '.widget-settings__controls-btns'),
                        classes;

                    parent.find('.widget-settings__controls-btn').each( function() {
                        classes = $( this ).data('class');
                        _widget.removeClass( classes );
                    } );

                    _widget.addClass( curClass );
                    _classesInput = _widget.attr( 'class').replace( _widgetClass, '' );
                    _inputHiddenClasses.val( _classesInput );

                    return false;
                }
            } );

            _itemColors.colorpicker().on( 'changeColor',
                function() {

                    _colorsInput = '';

                    _itemColors.each( function () {
                        _colorsInput += $( this ).find( 'input' ).val() + ' ';
                        _inputHiddenColors.val( _colorsInput );
                    } );

                } );

        },
        _init = function() {
            _addEvents();
            _addColorPicker();
        };

    //public properties

    //public methods

    _init();
};