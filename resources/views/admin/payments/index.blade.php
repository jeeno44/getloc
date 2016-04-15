@extends('admin.layouts.master')

@section('title')
    История платежей
@stop

@section('content')
    <div class="block block-bordered">
        <div class="block-content">
            <table class="table">
                <thead>
                <tr>
                    <th>Пользователь</th>
                    <th>Назначение</th>
                    <th>Сумма</th>
                    <th>Дата</th>
                    <th>Тип</th>
                    <th>Статус</th>
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
                            @if ($item->relation == 'App\Order')
                                Заказ перевода № {{$item->outer_id}}
                            @else
                                @if(!empty($item->subscription->plan->name) && !empty($item->subscription->site->name))
                                    Подписка на тарифный план {{$item->subscription->plan->name}} для проекта {{$item->subscription->site->name}}
                                @else
                                    Оплата подписки (проект или подписка удалены)
                                @endif

                            @endif
                        </td>
                        <td>
                            &#8381;{{number_format($item->sum, 0, '.', ' ') }}
                        </td>
                        <td>
                            {{date('d.m.Y H:i', strtotime($item->created_at))}}
                        </td>
                        <td>
                            @if($item->payment_type_id == 2)
                                @if(!empty($item->detail->id))
                                    <a role="button" data-toggle="collapse" href="#collapseExample{{$item->id}}" aria-expanded="false" aria-controls="collapseExample">
                                        {{$item->type->name}}
                                    </a>
                                    <div class="collapse" id="collapseExample{{$item->id}}">
                                        <strong>Контактное лицо:</strong> {{$item->detail->contact_name}}<br>
                                        <strong>Контактный телефон:</strong> {{$item->detail->contact_phone}}<br>
                                        <strong>Контактный email:</strong> {{$item->detail->contact_email}}<br>
                                        <strong>Юридический адрес:</strong> {{$item->detail->law_address}}<br>
                                        <strong>Почтовый адрес:</strong> {{$item->detail->post_address}}<br>
                                        <strong>Наименование организации:</strong> {{$item->detail->company_name}}<br>
                                        <strong>ИНН:</strong> {{$item->detail->company_inn}}<br>
                                        <strong>ОГРН:</strong> {{$item->detail->company_ogrn}}<br>
                                        <strong>Наименование банка:</strong> {{$item->detail->company_bank_name}}<br>
                                        <strong>Расчетный счет:</strong> {{$item->detail->company_bank_account}}<br>
                                        <strong>Бик:</strong> {{$item->detail->company_bank_bik}}<br>
                                        <strong>ФИО Руководителя:</strong> {{$item->detail->company_principal_name}}<br>
                                        <strong>Должность руководителя:</strong> {{$item->detail->company_principal_post}}<br>
                                    </div>
                                @else
                                    {{$item->type->name}}
                                @endif
                            @else
                                {{$item->type->name}}
                            @endif
                        </td>
                        <td>
                            {!! getPaymentStatus($item->status) !!}
                        </td>
                        <td>
                            @if($item->status == 'new')
                                <a class="btn btn-primary" data-toggle="modal" href="#modal-{{$item->id}}">Провести платеж</a>
                                <div class="modal fade" id="modal-{{$item->id}}">
                                    <form class="modal-dialog" action="/admin/billing/payments/{{$item->id}}/edit">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Провести платеж</h4>
                                            </div>
                                            <div class="modal-body">
                                                Вы уверены? Это действие необратимо.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    Отмена
                                                </button>
                                                <button type="submit" class="btn btn-primary">Провести</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </form><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $items->render() !!}
        </div>
    </div>
@stop