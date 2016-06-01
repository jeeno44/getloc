@extends('layouts.account')
@section('title') Виджет @stop
@section('content')
<aside class="site__aside">
    @include('partials.account-menu')
</aside>
<div class="inside-content">
    <h1 class="site__title">Настройки виджета</h1>
    <form method="POST" action="">
        <div class="widget-settings">
            <div class="widget-settings__controls">
                <input type="hidden" name="settings" class="widget-classes" value=" {{$class}}">
                <div class="widget-settings__controls-item">
                    <span>Расположение:</span>
                    <div class="widget-settings__controls-btns">
                        <a href="#" class="btn btn_12 widget-settings__controls-btn">Слева</a>
                        <a href="#" class="btn btn_12 widget-settings__controls-btn" data-class="right-pos">Справа</a>
                    </div>
                </div>
                <div class="widget-settings__controls-item">
                    <span>Название:</span>
                    <div class="widget-settings__controls-btns">
                        <a href="#" class="btn btn_12 widget-settings__controls-btn">Полные</a>
                        <a href="#" class="btn btn_12 widget-settings__controls-btn" data-class="abbreviations">Сокращения</a>
                    </div>
                </div>
                <div class="widget-settings__controls-item">
                    <span>Тема виджета:</span>
                    <div class="widget-settings__controls-btns">
                        <a href="#" class="btn btn_12 widget-settings__controls-btn" data-class="lightness">Светлая</a>
                        <a href="#" class="btn btn_12 widget-settings__controls-btn">Темная</a>
                        <a href="#" class="btn btn_12 widget-settings__controls-settings">Настроить</a>
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
                    <div class="widget__crafted">Create by getloc.com</div>
                </div>
            </div>
            <div class="widget-settings__colors" @if ($widget_data->theme == 'custom') style="display: block;" @endif>
                <input type="hidden" class="widget-colors" value="">
                <h2 class="site__title site__title_4">Настройки цвета</h2>
                <div class="widget-settings__colors-items">
                    <div class="widget-settings__colors-item colorpicker-element">
                        <span>Общий фон:</span>
                        <div class="widget-settings__choose-color">
                            <span class="input-group-addon"><i style="background-color: {{$widget_data->background}};"></i></span>
                            <input type="text" name="background" value="{{$widget_data->background}}" class="site__input">
                        </div>
                    </div>
                    <div class="widget-settings__colors-item colorpicker-element">
                        <span>Фон активного языка:</span>
                        <div class="widget-settings__choose-color">
                            <span class="input-group-addon"><i style="background-color: {{$widget_data->background_active}};"></i></span>
                            <input name="background_active"  type="text" value="{{$widget_data->background_active}}" class="site__input">
                        </div>
                    </div>
                    <div class="widget-settings__colors-item colorpicker-element">
                        <span>Цвет текста:</span>
                        <div class="widget-settings__choose-color">
                            <span class="input-group-addon"><i style="background-color: {{$widget_data->color}};"></i></span>
                            <input name="color" type="text" value="{{$widget_data->color}}" class="site__input">
                        </div>
                    </div>
                    <div class="widget-settings__colors-item colorpicker-element">
                        <span>Текст активного языка:</span>
                        <div class="widget-settings__choose-color">
                            <span class="input-group-addon"><i style="background-color: {{$widget_data->color_active}};"></i></span>
                            <input name="color_active" type="text" value="{{$widget_data->color_active}}" class="site__input">
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn_7 btn_blue" href="#">Сохранить изменения</button>
        </div>
    </form>
</div>
@stop