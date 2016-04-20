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

                        @foreach ($blocks as $t)

                            <div class="pages_block_wrap">
                                <input type="checkbox" data-id="{{ $t->id }}" class="pages_disable" @if($t->enabled) checked @endif>
                                <a href="/account/phrase?url={{ urlencode($t->url) }}" class="link_pages">{{ $t->url }}</a>
                            </div>

                        @endforeach

                        @if (isset($blocks))
                            <div class="paginationAjax">
                                {!! $blocks->appends(['site_id' => request()->get('site_id')])->links() !!}
                            </div>
                        @endif

                    </div>
                </div>

                <!-- tabs__content -->

            </div>
            <!--/tabs__wrap-->
        </div>
    </div>
@stop