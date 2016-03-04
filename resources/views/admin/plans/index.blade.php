@extends('admin.layouts.master')

@section('title')
    Тарифные планы&nbsp;&nbsp;
    <a class="btn btn-default btn-sm" href="/admin/billing/plans/create" data-toggle="tooltip" title="Новый тарифный план"><span class="fa fa-plus"></span> </a>
@stop

@section('content')
    <div class="block block-bordered">
        <div class="block-content">
            <table class="table">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Стоимость</th>
                    <th>Макс. слов</th>
                    <th>Макс. языков</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>
                            {{$item->name}}
                        </td>
                        <td>
                            &#8381;{{number_format($item->cost, 0, '.', ' ') }}
                        </td>
                        <td>
                            {{number_format($item->count_words, 0, '.', ' ')}}
                        </td>
                        <td>
                            {{$item->count_languages}}
                        </td>
                        <td class="text-right">
                            <a class="btn btn-sm btn-default" type="button" data-toggle="tooltip" title="Редактировать" href="/admin/billing/plans/{{$item->id}}/edit"><i class="fa fa-pencil"></i></a>
                            &nbsp;&nbsp;
                            <button class="btn btn-sm btn-default" type="button" data-toggle="modal" title="Удалить" data-target="#remove{{$item->id}}"><i class="fa fa-times"></i></button>
                            <div class="modal fade" tabindex="-1" role="dialog" id="remove{{$item->id}}">
                                <div class="modal-dialog">
                                    <form class="modal-content" method="post" action="/admin/billing/plans/{{$item->id}}">
                                        {!! Form::hidden('_method', 'DElETE') !!}
                                        {!! csrf_field() !!}
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title text-left">Удалить тариф?</h4>
                                        </div>
                                        <div class="modal-body text-left">
                                            <p>Удалить тариф {{$item->name}}?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                            <button type="submit" class="btn btn-danger">Удалить</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $items->render() !!}
        </div>
    </div>
@stop