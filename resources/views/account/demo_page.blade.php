@extends('layouts.account')

@section('title') Сбор текста @stop

@section('content')
    <aside class="site__aside">
        {!! accountMenu() !!}
    </aside>
    <div class="inside-content">

        <div class="site__wrap_2">
            <div class="site__panel_">
                <a href="{{route('main.account.selectProject')}}" class="site__back">{{trans('phrases.all_sites')}}</a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/account/collect" class="site__back">Страницы {{$page->site->name}}</a>
            </div>
            <ul class="statistic statistic_col-4" style="margin-top: 0">
                <li class="stat">
                    <!-- statistic__num -->
                    <span class="statistic__num">{{number_format($page->site->pages()->count(), 0, '.', ' ')}}</span>
                    <!-- /statistic__num -->
                    <span>{{trans('phrases.pages')}}</span>
                </li>
                <li class="stat">

                    <!-- statistic__num -->
                    <span class="statistic__num">{{number_format($page->site->count_blocks, 0, '.', ' ')}}</span>
                    <!-- /statistic__num -->

                    <span>{{trans('phrases.blocks')}}</span>
                </li>
                <li class="stat">

                    <!-- statistic__num -->
                    <span class="statistic__num">{{number_format($page->site->count_words, 0, '.', ' ')}}</span>
                    <!-- /statistic__num -->

                    <span>{{trans('phrases.words')}}</span>
                </li>
            </ul>

            <table class="projects">
                <thead>
                <tr>
                    <td>{{trans('phrases.text')}}</td>
                    <td>{{ucfirst(trans('phrases.words'))}}</td>
                    <td>{{ucfirst(trans('phrases.symbols'))}}</td>
                </tr>
                </thead>
                @foreach($page->blocks as $block)
                    <tr>
                        <td>
                            {!! $block->text !!}
                        </td>
                        <td>
                            {!! $block->count_words !!}
                        </td>
                        <td>
                            {!! $block->count_symbols !!}
                        </td>
                    </tr>
                @endforeach
            </table>

        </div>

    </div>

@stop
