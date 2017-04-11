@foreach($files as $file)
    <div class="phrases__item">
        <div class="phrases__item-col phrases__item-col_block">
            <img src="{{$file->original_url}}" style="max-height: 100px;">
        </div>
        @if(empty($file->deleted_at))
        <div class="phrases__item-col phrases__item-col_block phrases__item-col_translate">
            <label style="margin-bottom: 10px; display: block">Ссылка на переведенное изображение</label>
            <textarea style="min-height: 83px;" class="active" id="transid-{{$file->id}}">{{$file->trans_url}}</textarea>
        </div>
        @endif
        <div class="phrases__item-controls" style="padding: 5px; height: auto">
            @if(empty($file->deleted_at))
                <button class="save_translate_doc btn btn_blue btn_4" object-id="{{$file->id}}">{{trans('account.save')}}</button>
                <input type="file" style="display: none" class="upfiles" object-id="{{$file->id}}">
                <button class="btn btn_blue btn_4 prev-click" object-id="{{$file->id}}">Загрузить файл</button>
                <button class="btn btn_red btn_4 im-to-arch" object-id="{{$file->doc_id}}" style="float: right">В архив</button>
            @else
                <button class="btn btn_red btn_4 im-to-arch" object-id="{{$file->doc_id}}" style="float: right">Из архива</button>
            @endif
        </div>
    </div>
@endforeach