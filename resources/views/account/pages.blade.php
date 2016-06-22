@extends('layouts.account')
@section('title') {{trans('account.t_pages_title')}} @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <div class="pages">
            <h2 class="site__title">{{trans('account.t_pages_pages_project')}}</h2>
            <ul class="page__wrap">
                <li class="page__row page__row_title">
                    <!-- pages__page -->
                    <div class="pages__page">{{trans('account.t_pages_page')}}</div>
                    <!-- /pages__page -->
                    <!-- page__status -->
                    <div class="page__status">{{trans('account.t_pages_status')}}</div>
                    <!-- /page__status -->
                    <!-- page__words -->
                    <div class="page__words">{{trans('account.t_pages_words')}}</div>
                    <!-- /page__words -->
                    <!-- page__on-off -->
                    <div class="page__on-off">{{trans('account.t_pages_control')}}</div>
                    <!-- /page__on-off-->
                </li>
                @foreach ($pages as $p)
                    <li class="page__row @if ($p->enabled == 0) page__row_active @elseif($p->collected == 0) page__row_in-progress @endif">
                        @if($p->enabled)
                            <a href="/account/phrase?url={{ urlencode($p->url) }}" class="pages__page">{{ $p->url }}</a>
                        @else
                            <a href="/account/phrase?url={{ urlencode($p->url) }}" class="pages__page disabled" disabled="disabled">{{ $p->url }}</a>
                        @endif
                        <div class="page__status">
                            @if($p->collected == 1)
                                <span class="page__status-right"></span>
                            @else
                                <div class="page__tooltips page__status-progress">
                                    <div>{{trans('account.t_pages_in_work')}}</div>
                                </div>
                            @endif
                        </div>
                        <div class="page__words">{{$p->blocks()->sum('count_words')}}</div>
                        <div class="page__on-off">
                            @if($p->enabled)
                                <a href="/account/pages/disable/{{$p->id}}" class="btn btn_3"><span>{{trans('account.t_pages_off')}}</span><span>{{trans('account.t_pages_on')}}</span></a>
                            @else
                                <a href="/account/pages/enable/{{$p->id}}" class="btn btn_3"><span>{{trans('account.t_pages_off')}}</span><span>{{trans('account.t_pages_on')}}</span></a>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        @if(!empty($pages->render()))
            <div class="pagination-wrap">
                {!! $pages->render() !!}
            </div>
        @endif
    </div>
@stop