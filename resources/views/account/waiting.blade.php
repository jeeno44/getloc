@extends('layouts.account')
@section('title') Обзор проекта @stop
@section('content')
    <aside class="site__aside">
        @include('partials.account-menu-waiting')
    </aside>
    <div class="inside-content">
        <div class="site__content site_inner">

            <div class="site__wrap">

                <!-- site__panel -->
                <div class="site__panel">

                    <!-- site__title -->
                    <h1 class="site__title">{{beautyUrl($site->url)}}</h1>
                    <!-- /site__title -->

                    <span class="projects__done">{{trans('phrases.in_process')}}</span>

                </div>
                <!-- /site__panel -->

                <!-- projects -->
                <table class="projects" style="width: 100%">
                    <thead>
                    <tr>
                        <td>{{trans('phrases.page')}}</td>
                        <td class="projects__status">
                            <span>{{trans('phrases.status')}}</span>
                        </td>
                        <td>{{ucfirst(trans('phrases.blocks'))}}</td>
                        <td>{{ucfirst(trans('phrases.words'))}}</td>
                        <td>{{ucfirst(trans('phrases.symbols'))}}</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <td>
                                <a href="{{route('scan.page', ['id' => $page->id])}}">{{beautyUrl($page->url)}}</a>
                            </td>
                            <td class="projects__status">
                                @if ($page->collected == 1)
                                    <span class="projects__done">{{trans('phrases.page_done')}}</span>
                                @else
                                    <span class="projects__picking">{{trans('phrases.collect_text')}}</span>
                                @endif
                                @if ($page->code >= 400)
                                    <span class="label label-danger pull-right">{{trans('phrases.server_error')}} {{$page->code}}</span>
                                @endif
                            </td>
                            <td>
                                {{$page->count_blocks}}
                            </td>
                            <td>
                                {{$page->count_words}}
                            </td>
                            <td>
                                {{$page->count_symbs}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!-- /projects -->
                {{$pages->render()}}

            </div>

        </div>
    </div>
    <style>
        .projects{
            width: 100%;
            margin-bottom: 30px;
            color: #323232;
            border-bottom: 2px solid #e3e6e8;
        }
        .projects td{
            padding: 17px 20px 18px 30px;
            border-bottom: 1px solid #e3e6e8;
            vertical-align: middle;
        }
        .projects td:first-child{
            padding-left: 0;
        }
        .projects_list td{
            padding: 17px 15px;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }
        .projects_list td:first-child{
            padding-left: 15px;
        }
        .projects thead td{
            height: 46px;
            border-bottom-width: 2px;
            font-weight: 700;
        }
        .projects a{
            color: #18baea;
            border-bottom: 1px solid transparent;
            transition: border-bottom-color .3s ease;
            -webkit-transition: border-bottom-color .3s ease;
        }
        .projects a:hover{
            border-bottom-color: #18baea;
        }
        .projects__status span{
            padding-left: 22px;
        }
        .projects__picking{
            padding-left: 22px;
            color: #ccc;
            background: url("../img/icons-cogwheel.png") no-repeat 0 50%;
        }
        .projects__done{
            padding-left: 22px;
            background: url("../img/icons-btn-green.png") no-repeat 0 50%;
        }
        /* --------------- /projects --------------- */

        /* --------------- pagination --------------- */
        .pagination{
            margin-bottom: 50px;
            text-align: center;
        }
        .pagination li{
            display: inline-block;
            vertical-align: middle;
        }
        .pagination a{
            display: inline-block;
            width: 32px;
            height: 32px;
            margin: 0 6px;
            border: 1px solid transparent;
            border-radius: 50px;
            color: #333;
            line-height: 32px;
            transition: color .3s ease, border-color .3s ease, opacity .3s ease;
            -webkit-transition: color .3s ease, border-color .3s ease, opacity .3s ease;
        }
        .pagination .active a,
        .pagination a:hover{
            color: #66d1f1;
            border-color: #66d1f1;
        }
        .pagination .active a{
            cursor: default;
        }
        .pagination li:first-child a,
        .pagination li:last-child a{
            width: 13px;
            background: url("../img/icons-paginator.png") 0 50% no-repeat;
            text-indent: -9999px;
        }
        .pagination li:last-child a{
            background-position: -13px 50%;
        }
        .pagination li:first-child a:hover,
        .pagination li:last-child a:hover{
            border-color: transparent;
            opacity: .5;
        }
        .sr-only{
            position: absolute;
            width: 1px;
            height: 1px;
            margin: -1px;
            padding: 0;
            overflow: hidden;
            clip: rect(0,0,0,0);
            border: 0;
        }
        .site {
            position: relative;
            min-height: 100%;
            min-width: 952px;
            overflow: hidden;
            font: 14px 'Fira Sans', sans-serif;
            color: #333;
            z-index: 1;
        }
        .site:before,
        .site:after {
            content: '';
            display: block;
            clear: both;
            width: 100%;
            height: 65px;
        }
        .site:after{
            height: 300px;
        }
        .site_inner{
            padding-top: 53px;
        }
        .site__title{
            margin-bottom: 24px;
            font-size: 30px;
            font-weight: normal;
            text-align: center;
        }
        .site__title span{
            font-weight: 700;
            color: #ffd400;
        }
        .site__header {
            position: absolute;
            left: 0;
            right: 0;
            height: 65px;
            padding-top: 16px;
            font-size: 14px;
            font-weight: 400;
            background: url("../img/bg-header.jpg") no-repeat top center #0966a2;
            background-size: cover;
            transform: translateY(-65px);
            -webkit-transform: translateY(-65px);
            transition: transform .3s ease;
            -webkit-transition: -webkit-transform .3s ease;
            z-index: 3;
        }
        .site__header-layout {
            position: relative;
            width: 992px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .site__content {
            position: relative;
            z-index: 2;
        }
        .site__wrap{
            width: 992px;
            padding: 0 20px;
            margin: 0 auto;
        }
        .site__content-layout {
            width: 950px;
        }
        .site__footer {
            z-index: 2;
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 300px;
            padding-top: 61px;
            background-color: #434954;
        }
        .site__footer-layout {
            position: relative;
            width: 992px;
            height: 300px;
            padding: 0 20px;
            margin: 0 auto;
        }
        .site__introduction{
            margin: 0 257px 51px;
            line-height: 24px;
            text-align: center;
        }
        .site__panel{
            height: 46px;
            margin-bottom: 49px;
            padding: 0 31px;
            text-align: justify;
        }
        .site__panel:after{
            content: '';
            display: inline-block;
            width: 100%;
        }
        .site__panel span,
        .site__panel a{
            display: inline-block;
        }
        .site__panel .site__title{
            display: inline-block;
        }
        .site__back{
            position: relative;
            margin-left: 25px;
            color: #18baea;
            border-bottom: 1px solid #18baea;
        }
        .site__back:before{
            content: '';
            position: absolute;
            top: 50%;
            left: -25px;
            width: 12px;
            height: 10px;
            margin-top: -5px;
            background: url("../img/icons-arrows.png") no-repeat 0 0;
            transform: rotate(180deg);
            -webkit-transform: rotate(180deg);
        }
        .header_platform{
            height: 170px;
            background: url("../img/bg-header-platform.png") no-repeat bottom center,
            url("../img/bg-header.jpg") no-repeat top center/cover #0966a2;
        }
        .site__header-inner {
            position: absolute;
            top: 1px;
            right: 20px;
            text-align: right;
        }
        .site__header-inner > * {
            display: inline-block;
            vertical-align: top;
            margin-left: 9px;
        }
        .site__header-inner > *:first-child {
            margin-left: 0;
        }
        .site__form {
            margin: 0 30px 20px;
            padding: 0 59px 56px;
            border-bottom: 1px solid #e6e6e6;
            text-align: center;
        }
        .site__form fieldset {
            margin-bottom: 9px;
        }
        .site__form label {
            display: block;
            margin-bottom: 2px;
            color: #ccc;
            -webkit-transition: color 0.3s ease;
            transition: color 0.3s ease;
        }
        .site__form .focused label {
            color: #333;
        }
        .site__form input {
            display: block;
            padding: 0 10px;
            width: 100%;
            height: 40px;
            color: #333;
            border-radius: 4px;
            border: 1px solid #d0d0d0;
            font-family: 'Fira Sans', sans-serif;
            font-size: 14px;
            text-align: center;
            -webkit-transition: border 0.3s ease, color 0.3s ease;
            transition: border 0.3s ease, color 0.3s ease;
        }
        .site__form input:focus {
            border-color: #18baea;
        }
        .site__form-forgot {
            display: inline-block;
            color: #333;
            border-bottom: 1px solid #333;
            line-height: 1;
            -webkit-transition: border-bottom 0.3s ease;
            transition: border-bottom 0.3s ease;
        }
        .site__form-forgot:hover {
            border-bottom: 1px solid transparent;
        }
        .site__form button[type='submit'] {
            display: block;
            width: 100%;
            margin: 28px 0 22px;
            font-weight: 500;
        }
        .site__form-title {
            display: block;
            color: #333;
            font-size: 20px;
            margin-bottom: 26px;
        }
        .site__form .error input {
            border: 1px solid #ff6353;
            color: #ff6353;
        }
    </style>
@stop