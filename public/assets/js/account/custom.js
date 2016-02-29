$(function(){
    $('.turnLang').click(function(){
        $.ajax({
            url     : "/account/switchingLanguage/",
            type    : 'post',
            data    : {langID: parseInt($(this).attr('data-langid'))}
        }); 
    })
})