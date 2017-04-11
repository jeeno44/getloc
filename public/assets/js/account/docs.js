imagesPage = 1;

$(function() {
   $('input[type=radio]').first().trigger('click');
   $(document).on('click', '.prev-click', function (e) {
       $(this).prev().trigger('click');
       e.preventDefault();
   });
   $('input[type=radio]').click(loadImages);
   loadImages();
    $('.inside-content').on('click', '.paginator-images>ul>li>a', function(e){
        imagesPage = $(this).attr('href').split('page=')[1];
        loadImages();
        e.preventDefault();
    });
    $('.inside-content').on('click', '.im-to-arch', function(e){
        var id = $(this).attr('object-id');
        $.ajax({
            url         : "/account/filter/archive/" + id,
            type        : 'post',
            dataType    : 'json',
            beforeSend  : startLoaderDocs,
            success     : function()
            {
                loadImages();
            }
        });
        e.preventDefault();
    });
    $('.inside-content').on('click', '.save_translate_doc', function(e){
        var id = $(this).attr('object-id');
        var text = $('#transid-' + id).val();
        $.ajax({
            url         : "/account/filter/save/" + id,
            type        : 'post',
            dataType    : 'json',
            data        : {text: text},
            beforeSend  : startLoaderDocs,
            success     : function()
            {
                //toastr.success('Сохранено');
                loadImages();
            }
        });
        e.preventDefault();
    });
    $('.inside-content').on('change', '.upfiles', function(e){
        var id = $(this).attr('object-id');
        var file = this.files[0];
        var fd = new FormData();
        fd.append("file", file);
        console.log(fd);
        $.ajax({
            url         : "/account/filter/upload/" + id,
            type        : 'post',
            beforeSend  : startLoaderDocs,
            cache: false,
            contentType: false,
            processData: false,
            data: fd,
            success     : function()
            {
                loadImages();
            },
            fail: function () {
                loadImages();
            }
        });
        e.preventDefault();
    });
});

function loadImages() {
    var pathname = window.location.pathname;
    if (pathname.indexOf('account/images') >= 0) {
        url = "/account/filter/images";
    } else {
        url = "/account/filter/docs";
    }
    if ($('#images-block').length < 1) {
        return;
    }
    var pages = [];
    var lang = undefined;
    $('.search-pages__chosen-item').each(function () {
        var text = $(this).find('div').text();
        if (text != undefined && text != '') {
            pages.push(text);
        }
    });
    $('input[name=lang]').each(function () {
        if ($(this).is(':checked')) {
           lang = $(this).val();
        }
    });
    $.ajax({
        url         : url,
        type        : 'post',
        data        : {page: imagesPage, pages: pages, lang: lang, site_id: $('#site-id').val()},
        dataType    : 'json',
        beforeSend  : startLoaderDocs,
        success     : function(phrases)
        {
            stopLoaderDocs();
            if (phrases.files != '') {
                $('#images-block').html(phrases.files);
                $('.paginator-images').html(phrases.pager);
            } else {
                $('#images-block').text('Документы по вашим условиям не найдены');
                $('.paginator-images').html('');
            }

            $('#arch').text(phrases.arch);
            for(var k in phrases.langs) {
                ct = parseInt(phrases.langs[k]['count_trans']);
                cd = parseInt(phrases.langs[k]['count_docs']);
                if (ct > cd) {
                    ct = cd;
                }
                $('#lang_proc_' + phrases.langs[k]['id']).text(ct + '/' + cd);
            }
        },
        fail: function () {
            stopLoaderDocs();
        }
    })
}

function loadDocs() {
    
}

startLoaderDocs = function()
{
    $('#images-block').empty().html('<div class="preloader"><img src="/assets/img/account/loader.svg" /></div>')
}

stopLoaderDocs  = function()
{
    $('#images-block').empty()
}
