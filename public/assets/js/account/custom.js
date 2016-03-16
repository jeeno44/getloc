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
    
    $('#setViewTypeID_1').click(function(){setFilterShow(1)});
    $('#setViewTypeID_2').click(function(){setFilterShow(2)});
    
    $('#check').click(function(){
        $(".checkboxPhrase").prop('checked', $(this).prop("checked"));
    });
    
    $('#check-all-phrases').click(function(){
        setStatusBlock(1)
    })
    
    $('#nopublishing').click(function(){
        setStatusBlock(2)
    })
        
    $('.go_robot').click(function(){
        var id = $(this).attr('data-id')
        var ob = $(this)
        $.ajax({
            url     : "/account/robot/" + id,
            type    : 'post',
            dataType: 'text',
            cache   : false,
            success : function(res)
            {
                $('#order_'+id).val(res).css('height', '50px')
                if ( ob.hasClass('isLinkMoreMenu') )
                  {
                    alert('Готово')
                  }
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
})

setStatusBlock = function(status)
{
    var data = {status: status, ids: []}
    $(".checkboxPhrase:checked").each(function(){
        data['ids'].push($(this).val());
    })
    
    $.ajax({
        url     : "/account/setStatusBlock/",
        type    : 'post',
        data    : data,
        success : function()
        {
            window.location.reload();
        }
    });
}

setFilterShow = function(typeViewID)
{
    $.ajax({
        url     : "/account/setTypeView/",
        type    : 'post',
        data    : {typeViewID: typeViewID},
        success : function()
        {
            window.location.reload()
        }
    });
}

markHandTranslate = function(id)
{
    $.ajax({
        url     : "/account/markHandTranslate/" + id,
        type    : 'post',
        success : function()
        {
            alert('Готово')
        }
    });
}