@extends('admin.layouts.master')

@section('title')
    Купоны&nbsp;&nbsp;
    <a class="btn btn-default btn-sm" href="/admin/billing/coupons/create" data-toggle="tooltip" title="Новый тарифный план"><span class="fa fa-plus"></span> </a>
@stop

@section('content')
    <div class="block block-bordered">
        <div class="block-content">
            <table class="table">
                <thead>
                <tr>
                    <th>Код</th>
                    <th>Скидка</th>
                    <th>Тип</th>
                    <th>Статус</th>
                    <th>Активация</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>
                            {{$item->code}}
                        </td>
                        <td>
                            @if($item->is_percent == 0)&#8381;@endif
                            {{$item->discount}}
                            @if($item->is_percent == 1)%@endif
                        </td>
                        <td>
                            {{getCouponTypes($item->type)}}
                            @if ($item->type == 'fixed') {{date('d.m.Y', strtotime($item->ends_at))}} @endif
                        </td>
                        <td>
                            @if($item->enabled == 1) Открыт @else Завершен @endif
                        </td>
                        <td>
                            @if($item->activated_at == '0000-00-00 00:00:00')
                                Не активирован
                            @else
                                Активирован для сайта {{$item->site->name}}
                            @endif
                        </td>
                        <td class="text-right">
                            <a class="btn btn-sm btn-default" type="button" data-toggle="tooltip" title="Редактировать" href="/admin/billing/coupons/{{$item->id}}/edit"><i class="fa fa-pencil"></i></a>
                            &nbsp;&nbsp;
                            <button class="btn btn-sm btn-default" type="button" data-toggle="modal" title="Удалить" data-target="#remove{{$item->id}}"><i class="fa fa-times"></i></button>
                            <div class="modal fade" tabindex="-1" role="dialog" id="remove{{$item->id}}">
                                <div class="modal-dialog">
                                    <form class="modal-content" method="post" action="/admin/billing/coupons/{{$item->id}}">
                                        {!! Form::hidden('_method', 'DElETE') !!}
                                        {!! csrf_field() !!}
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title text-left">Удалить купон?</h4>
                                        </div>
                                        <div class="modal-body text-left">
                                            <p>Удалить купон {{$item->name}}?</p>
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