@extends('layouts.account')
@section('title') Личная информация @stop
@section('content')
    <aside class="site__aside">
        <div class="site__aside-menu">
            <a class="active" href="">Персональные данные</a>
            <a class="site__aside-menu-isolated" href="{{URL::route('logout')}}">Выйти</a>
        </div>
    </aside>
    <div class="inside-content">
        <div class="account-data">
            <h1 class="site__title">Персональные данные</h1>
            <form action="" class="account-data__form" method="post">
                {!! csrf_field() !!}
                <div class="account-data__main">
                    <div class="site__data-field">
                        <label class="site__label" for="your-name">Ваше имя</label>
                        <input type="text" class="site__input" name="visibility_name" id="your-name" value="{{Auth::user()->visibility_name}}">
                    </div>
                    <div class="site__data-field">
                        <label class="site__label" for="your-email">Эл. почта</label>
                        <input type="email" class="site__input" name="email" id="your-email" value="{{Auth::user()->email}}">
                    </div>
                </div>
                <h2 class="site__title site__title_4">Изменить пароль</h2>
                <div class="account-data__change-pass">
                    <div class="site__data-field">
                        <label class="site__label" for="new-pass">Введите новый пароль</label>
                        <input type="password" class="site__input new-pass" name="password" id="new-pass">
                    </div>
                    <div class="site__data-field">
                        <label class="site__label" for="repeat-pass">Повторите пароль</label>
                        <input type="password" class="site__input repeat-pass" name="password_confirmation" id="repeat-pass">
                    </div>
                </div>
                <button type="submit" class="btn btn_7 btn_blue account-data__save">Сохранить изменения</button>
            </form>
        </div>
    </div>
@stop