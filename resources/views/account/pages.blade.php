@extends('layouts.account')
@section('title') Страницы проекта @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <div class="pages">
            <h2 class="site__title">Страницы проекта</h2>
            <ul class="page__wrap">
                <li class="page__row page__row_title">
                    <!-- pages__page -->
                    <div class="pages__page">Страница</div>
                    <!-- /pages__page -->
                    <!-- page__status -->
                    <div class="page__status">Статус</div>
                    <!-- /page__status -->
                    <!-- page__words -->
                    <div class="page__words">Слов</div>
                    <!-- /page__words -->
                    <!-- page__on-off -->
                    <div class="page__on-off">Вкл./откл. перевод</div>
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
                                    <div>В обработке</div>
                                </div>
                            @endif
                        </div>
                        <div class="page__words">{{$p->blocks()->sum('count_words')}}</div>
                        <div class="page__on-off">
                            @if($p->enabled)
                                <a href="/account/pages/disable/{{$p->id}}" class="btn btn_3"><span>Отключить</span><span>Включить</span></a>
                            @else
                                <a href="/account/pages/enable/{{$p->id}}" class="btn btn_3"><span>Отключить</span><span>Включить</span></a>
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