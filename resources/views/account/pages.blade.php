@extends('layouts.account')
@section('title') Страницы проекта @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu')
    </aside>
    <div class="inside-content">
        <div class="phrases">
                <h1 class="site__title">Страницы проекта</h1>

            <div class="magic_tabs"{{-- class="tabs"--}}>

                <div class="tabs__content">
                    <div class="active" style="display: block;" class="phrases__tab" id="renderPhrases">
                        <table style="width: 100%">
                        @foreach ($pages as $p)
                            <tr>
                                <td>{{ $p->url }}</td>
                                <td>
                                    @if($p->enabled)
                                        <a href="/account/phrase?url={{ urlencode($p->url) }}" class="link_pages">Показать фразы</a>
                                    @endif
                                </td>
                                <td>
                                @if($p->enabled)
                                    <a href="/account/pages/disable/{{$p->id}}">Отключить от перевода</a>
                                @else
                                    <a href="/account/pages/enable/{{$p->id}}">Подключить к переводу</a>
                                @endif
                                </td>
                            </tr>
                        @endforeach
                        </table>
                            <div class="pagination">
                                {!! $pages->render() !!}
                            </div>

                    </div>
                </div>

                <!-- tabs__content -->

            </div>
            <!--/tabs__wrap-->
        </div>
    </div>
@stop