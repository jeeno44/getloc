@extends('admin.layouts.master')

@section('title')
    Приобретенные подписки
@stop

@section('content')
    <div class="block block-bordered">
        <div class="block-content">
            <table class="table">
                <thead>
                <tr>
                    <th>Пользователь</th>
                    <th>Тариф</th>
                    <th>Дата окончания</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>
                            {{$item->user->name}}
                        </td>
                        <td>
                            {{$item->plan->name}}
                        </td>
                        <td>
                            {{$item->ends_at}}
                        </td>
                        <td>
                            <button class="btn btn-sm btn-default" type="button" data-toggle="modal" title="Удалить" data-target="#remove{{$item->id}}"><i class="fa fa-times"></i></button>
                            <div class="modal fade" tabindex="-1" role="dialog" id="remove{{$item->id}}">
                                <div class="modal-dialog">
                                    <form class="modal-content" method="post" action="/admin/billing/subscriptions/{{$item->id}}">
                                        {!! Form::hidden('_method', 'DElETE') !!}
                                        {!! csrf_field() !!}
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title text-left">Удалить подписку?</h4>
                                        </div>
                                        <div class="modal-body text-left">
                                            <p>Удалить подписку пользователя {{$item->user->name}}?</p>
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