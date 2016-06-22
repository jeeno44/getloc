@extends('layouts.account')
@section('title') {{trans('account.t_widget_title')}} @stop
@section('content')
<aside class="site__aside">
    @include('partials.account-menu')
</aside>
<div class="inside-content">
    <h1 class="site__title">{{trans('account.t_widget_header')}}</h1>
    <form method="POST" action="">
        <div class="widget-settings">
            <div class="widget-settings__controls">
                <input type="hidden" name="settings" class="widget-classes" value=" {{$class}}">
                <div class="widget-settings__controls-item">
                    <span>{{trans('account.t_widget_position')}}:</span>
                    <div class="widget-settings__controls-btns">
                        <a href="#" class="btn btn_12 widget-settings__controls-btn">{{trans('account.t_widget_position_left')}}</a>
                        <a href="#" class="btn btn_12 widget-settings__controls-btn" data-class="right-pos">{{trans('account.t_widget_position_right')}}</a>
                    </div>
                </div>
                <div class="widget-settings__controls-item">
                    <span>{{trans('account.t_widget_names')}}:</span>
                    <div class="widget-settings__controls-btns">
                        <a href="#" class="btn btn_12 widget-settings__controls-btn">{{trans('account.t_widget_names_full')}}</a>
                        <a href="#" class="btn btn_12 widget-settings__controls-btn" data-class="abbreviations">{{trans('account.t_widget_names_short')}}</a>
                    </div>
                </div>
                <div class="widget-settings__controls-item">
                    <span>{{trans('account.t_widget_theme')}}:</span>
                    <div class="widget-settings__controls-btns">
                        <a href="#" class="btn btn_12 widget-settings__controls-btn" data-class="lightness">{{trans('account.t_widget_theme1')}}</a>
                        <a href="#" class="btn btn_12 widget-settings__controls-btn">{{trans('account.t_widget_theme2')}}</a>
                        <a href="#" class="btn btn_12 widget-settings__controls-settings">{{trans('account.t_widget_theme3')}}</a>
                    </div>
                </div>
            </div>
            <div class="widget-settings__view">
                <div class="widget__menu {{$class}}">
                    <a href="#">
                        <span class="widget__menu-full">Русский</span>
                        <span class="widget__menu-abbreviations">RU</span>
                    </a>
                    <a href="#" class="active">
                        <span class="widget__menu-full">Английский</span>
                        <span class="widget__menu-abbreviations">EN</span>
                    </a>
                    <a href="#">
                        <span class="widget__menu-full">Французский</span>
                        <span class="widget__menu-abbreviations">FR</span>
                    </a>
                    <div class="widget__crafted">Uses get-loc.com</div>
                </div>
            </div>
            <div class="widget-settings__colors" @if ($widget_data->theme == 'custom') style="display: block;" @endif>
                <input type="hidden" class="widget-colors" value="">
                <h2 class="site__title site__title_4">{{trans('account.t_widget_setting_colors')}}</h2>
                <div class="widget-settings__colors-items">
                    <div class="widget-settings__colors-item colorpicker-element">
                        <span>{{trans('account.t_widget_background_all')}}:</span>
                        <div class="widget-settings__choose-color">
                            <span class="input-group-addon"><i style="background-color: {{$widget_data->background}};"></i></span>
                            <input type="text" name="background" value="{{$widget_data->background}}" class="site__input">
                        </div>
                    </div>
                    <div class="widget-settings__colors-item colorpicker-element">
                        <span>{{trans('account.t_widget_background_active')}}:</span>
                        <div class="widget-settings__choose-color">
                            <span class="input-group-addon"><i style="background-color: {{$widget_data->background_active}};"></i></span>
                            <input name="background_active"  type="text" value="{{$widget_data->background_active}}" class="site__input">
                        </div>
                    </div>
                    <div class="widget-settings__colors-item colorpicker-element">
                        <span>{{trans('account.t_widget_color_text')}}:</span>
                        <div class="widget-settings__choose-color">
                            <span class="input-group-addon"><i style="background-color: {{$widget_data->color}};"></i></span>
                            <input name="color" type="text" value="{{$widget_data->color}}" class="site__input">
                        </div>
                    </div>
                    <div class="widget-settings__colors-item colorpicker-element">
                        <span>{{trans('account.t_widget_color_active_text')}}:</span>
                        <div class="widget-settings__choose-color">
                            <span class="input-group-addon"><i style="background-color: {{$widget_data->color_active}};"></i></span>
                            <input name="color_active" type="text" value="{{$widget_data->color_active}}" class="site__input">
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn_7 btn_blue" href="#">{{trans('account.t_widget_save')}}</button>
        </div>
    </form>
</div>
@stop