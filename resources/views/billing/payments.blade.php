@extends('layouts.account')
@section('title') {{trans('account.t_history_pay_title')}} @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <div class="block block-bordered">
            <div class="block-content">
                @if($payments->count())
                <table class="projects">
                    <thead>
                    <tr>
                        <td>{{trans('account.t_history_pay_naznachenie')}}</td>
                        <td>{{trans('account.t_history_pay_summa')}}</td>
                        <td>{{trans('account.t_history_pay_date')}}</td>
                        <td>{{trans('account.t_history_pay_type')}}</td>
                        <td>{{trans('account.t_history_pay_status')}}</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payments as $item)
                        <tr>
                            <td>
                                @if ($item->relation == 'App\Order')
                                    {{trans('account.t_history_pay_text_order')}} {{$item->outer_id}}
                                @else
                                    @if(!empty($item->subscription->plan->name) && !empty($item->subscription->site->name))
                                        {{trans('account.t_history_pay_text1')}} {{$item->subscription->plan->name}} {{trans('account.t_history_pay_for_project')}} {{$item->subscription->site->name}}
                                    @else
                                        {{trans('account.t_history_pay_text2')}}
                                    @endif

                                @endif
                            </td>
                            <td>
                                &#8381;{{number_format($item->sum, 1, '.', ' ') }}
                            </td>
                            <td>
                                {{date('d.m.Y H:i', strtotime($item->created_at))}}
                            </td>
                            <td>
                                {{$item->type->name}}
                            </td>
                            <td>
                                {!! getPaymentStatus($item->status) !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                    <div class="warn_panel" style="width: 100%; margin-bottom: 20px;">
                        <p>Вы не совершали ни одного платежа</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop