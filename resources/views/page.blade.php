@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li><a href="/home/">Главная</a></li>
        <li><a href="/home/site/{{$page->site_id}}">Страницы сайта {{$page->site->url}}</a></li>
        <li class="active">Список текстов страницы {{$page->url}}</li>
    </ol>
    <div class="row">
        <div class="col-sm-6">
            <h3>Блоки</h3>
        </div>
        <form class="col-sm-6" method="get">
            {!! Form::select('lang', $langs, Input::get('lang', ''), ['class' => 'form-control']) !!}
            <script>
                $().ready(function(){
                    $('select').change(function(){
                        $(this).closest('form').submit();
                    });
                    $('.quick-edit').change(function(){
                        var id = $(this).attr('data-id');
                        var page = $(this).attr('data-page');
                        var val = $(this).val();
                        $.ajax('/api/change-text/' + id, {
                            method: 'POST',
                            data: {text: val, page: page}
                        });
                    });
                });
            </script>
        </form>
    </div>

    @if (!empty($lang))
        <table class="table table-bordered table-responsive table-hovered">
            <thead>
            <tr>
                <th>Текст</th>
                <th>Перевод</th>
            </tr>
            </thead>
            @foreach($blocks as $block)
                <tr>
                    <td class="col-sm-6">
                        {!! $block->text !!}
                    </td>
                    <td>
                        @if (!empty($block->ttext))
                            @if (Auth::user() != null && Auth::user()->id == $page->site->user_id)
                                <textarea class="quick-edit form-control" data-id="{{$block->tid}}" rows="5" data-page="{{$page->id}}">{{$block->ttext}}</textarea>
                            @else
                                 {{$block->ttext}}
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <table class="table table-bordered table-responsive table-hovered">
            <thead>
            <tr>
                <th>Текст</th>
                <th>Слов</th>
                <th>Символов</th>
            </tr>
            </thead>
            @foreach($page->blocks as $block)
                <tr>
                    <td>
                        {!! $block->text !!}
                    </td>
                    <td>
                        {!! $block->count_words !!}
                    </td>
                    <td>
                        {!! $block->count_symbols !!}
                    </td>
                </tr>
            @endforeach
        </table>
    @endif


@stop