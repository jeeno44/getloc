@extends('admin.layouts.master')

@section('title')
    Контрагенты&nbsp;&nbsp;
@stop

@section('content')
    <div class="block block-bordered">
        <div class="block-content">
            <table class="table">
                <thead>
                <tr>
                    <th>Почта</th>
                    <th>Имя</th>
                    <th>Просчетов</th>
                    <th>Макс. демо сайтов</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>
                            {{$item->email}}
                        </td>
                        <td>
                            {{$item->visibility_name}}
                        </td>
                        <td>
                            {{$item->sites->count()}}
                        </td>
                        <td>
                            {{$item->max_sites}}
                        </td>
                        <td class="text-right">
                            <a class="btn btn-sm btn-default" type="button" data-toggle="tooltip" title="Редактировать" href="/users/{{$item->id}}/edit"><i class="fa fa-pencil"></i></a>
                            &nbsp;&nbsp;
                            <button class="btn btn-sm btn-default" type="button" data-toggle="modal" title="Удалить" data-target="#remove{{$item->id}}"><i class="fa fa-times"></i></button>
                            <div class="modal fade" tabindex="-1" role="dialog" id="remove{{$item->id}}">
                                <div class="modal-dialog">
                                    <form class="modal-content" method="post" action="/users/{{$item->id}}">
                                        {!! Form::hidden('_method', 'DElETE') !!}
                                        {!! csrf_field() !!}
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title text-left">Удалить пользователя?</h4>
                                        </div>
                                        <div class="modal-body text-left">
                                            <p>Удалить пользователя {{$item->email}}?</p>
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