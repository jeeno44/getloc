@extends('layouts.account')
@section('title') Добавить проект @stop
@section('content')
<h1 class="site__title">Создание нового проекта</h1>

<div class="new-project">
    <!-- new-project
    <a class="new-project__skip" href="#">Пропустить работу помощника →</a>
    /new-project -->
    <!-- new-project__pros -->
    <div class="new-project__pros">
        <!-- new-project__pic -->
        <div class="new-project__pic" style="background-image: url(/assets/img/account/create-pic.png)"></div>
        <!-- new-project__list -->
        <ul class="new-project__list">
            <li>Автоматическое составление карты сайта</li>
            <li>Определение количества слов и текста для перевода</li>
            <li>Переводите сами или используйте машинный перевод</li>
            <li>Закажите профессиональный перевод</li>
            <li>Перевод в 1 клик</li>
            <li>Более 20 поддерживаемых языков и многое другое</li>
        </ul>
        <!-- /new-project__list -->
    </div>
    <!-- /new-project__pros -->
    <!-- new-project__form -->
    <div class="new-project__form">
        @if($errors->any())
            @foreach($errors->all() as $e)
                <div style="background: red;color: white">{{$e}}</div>
            @endforeach
        @endif
        <form class="site__form" method="post" action="{{route('main.account.post-add-project')}}" novalidate>
            <fieldset>
                <div class="site__data-field">
                    <label class="site__label" for="name-project">Название проекта</label>
                    <input type="text" class="site__input" name="name" id="name-project" required>
                </div>
                <div class="new-project__question">
                    <span></span>
                    <div class="new-project__question-text">
                        В случае если вы имеете файл локализации. Мы применим инструменты перевода только к загруженным файлам локализации. Ознакомьтесь с
                        <a class="new-project__question-link" href="#">поддерживаемыми форматами</a>
                        файлов локализаций.
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <div class="site__data-field">
                    <label class="site__label" for="link-project">Ссылка на проект</label>
                    <input type="text" class="site__input" name="url" id="link-project" required>
                </div>
                <div class="new-project__question">
                    <span></span>
                    <div class="new-project__question-text">
                        В случае если вы имеете файл локализации. Мы применим инструменты перевода только к загруженным файлам локализации. Ознакомьтесь с
                        <a class="new-project__question-link" href="#">поддерживаемыми форматами</a>
                        файлов локализаций.
                    </div>

                </div>
            </fieldset>
            <fieldset class="discount__language">
                <!-- site__data-field -->
                <div class="site__data-field">
                    <label class="site__label">Основной язык проекта</label>
                    <!-- new-project__question -->
                    <div class="new-project__question">
                        <span></span>
                        <!-- new-project__question-text -->
                        <div class="new-project__question-text">
                            В случае если вы имеете файл локализации. Мы применим инструменты перевода только к загруженным файлам локализации. Ознакомьтесь с
                            <!-- new-project__question-link -->
                            <a class="new-project__question-link" href="#">поддерживаемыми форматами</a>
                            <!-- /new-project__question-link -->
                            файлов локализаций.
                        </div>
                        <!-- /new-project__question-text -->
                    </div>
                    <!-- /new-project__question -->

                    <!-- options__selects-wrap -->
                    <div class="discount__selects-language " data-language='{{getLanguagesJson()}}'>
                        <!-- discount__language-wrapper -->
                        <div class="discount__language-wrapper">
                            <select name="language[]" id="lang_1">
                                <option value="0">Выберите язык</option>
                            </select>
                        </div>
                        <!-- /discount__language-wrapper -->
                    </div>
                    <!-- /site__data-field -->
                </div>
                <!-- /discount__selects-language -->
            </fieldset>

            <fieldset class="discount__language">
                <!-- site__data-field -->
                <div class="site__data-field">
                    <label class="site__label">Перевести проект на язык</label>
                    <!-- new-project__question -->
                    <div class="new-project__question">
                        <span></span>
                        <!-- new-project__question-text -->
                        <div class="new-project__question-text">
                            В случае если вы имеете файл локализации. Мы применим инструменты перевода только к загруженным файлам локализации. Ознакомьтесь с
                            <!-- new-project__question-link -->
                            <a class="new-project__question-link" href="#">поддерживаемыми форматами</a>
                            <!-- /new-project__question-link -->
                            файлов локализаций.
                        </div>
                        <!-- /new-project__question-text -->
                    </div>
                    <!-- /new-project__question -->
                    <!-- options__selects-wrap -->
                    <div class="discount__selects-language discount__selects-language_2" data-language='{{getLanguagesJson()}}'>
                        <!-- discount__language-wrapper -->
                        <div class="discount__language-wrapper">
                            <select name="language[]" id="lang_3">
                                <option value="0">Выберите язык</option>
                            </select>
                        </div>
                        <!-- /discount__language-wrapper -->
                        <a href="#" class="discount__languadge-add">Добавить направление перевода</a>
                    </div>
                    <!-- /discount__selects-language -->
                </div>
                <!-- /site__data-field -->
            </fieldset>
            <!-- nice-check -->
            <fieldset class="nice-check new-project__form-check">
                <input type="checkbox" value="1" name="project__check" id="new-project1">
                <label for="new-project1">
                    У меня есть файл перевода (локализации) проекта
                </label>
            </fieldset>
            <fieldset class="nice-check new-project__form-check">
                <input type="checkbox" value="1" name="protected" id="new-project2">
                <label for="new-project2">
                    Ваш сайт использует защиту (фаервол, проективная защита)?
                </label>
            </fieldset>
            <!-- /nice-check -->
            <!-- btn  -->
            <button class="btn btn_9 btn_blue">Создать проект</button>
            <!-- /btn  -->
        </form>
    </div>
    <!-- /new-project__form -->
</div>
@stop