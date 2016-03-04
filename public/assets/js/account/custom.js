$(function(){
    $('.turnLang').click(function(){
        $.ajax({
            url     : "/account/switchingLanguage/",
            type    : 'post',
            data    : {langID: parseInt($(this).attr('data-langid'))}
        }); 
    })
    
    $('#site-list').change(function(){
        window.location.href = $(this).val()
    })
    
    $('.save_translate').click(function(){
        $.ajax({
            url     : "/account/handTranslate/",
            type    : 'post',
            data    : {text: $('#order_'+$(this).attr('object-id')).val(), id: $(this).attr('object-id')},
            success : function(res)
            {
                $('#order_'+id).val(res).css('height', '50px')
            }
        });
    })
    
    $('.go_robot').click(function(){
        var id = $(this).attr('data-id')
        $.ajax({
            url     : "/account/robot/" + id,
            type    : 'post',
            dataType: 'text',
            cache   : false,
            success : function(res)
            {
                $('#order_'+id).val(res).css('height', '50px')
            }
        });
    })
})