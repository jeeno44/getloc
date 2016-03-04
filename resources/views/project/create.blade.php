@extends('layouts.account')
@section('title') Добавить проект @stop
@section('content')
<h1 class="site__title title_project">Создайте проект</h1>

<div class="new-project">
    {{--
    <a class="new-project__skip" href="#">Пропустить работу помощника →</a>
    --}}
    <div class="new-project__pros">
        <div class="new-project__pic" style="background-image: url(/assets/img/account/create-pic.png)"></div>
        <ul>
            <li>Автоматическое составление карты сайта</li>
            <li>Определение количества слов и текста для перевода</li>
            <li>Переводите сами или используйте машинный перевод</li>
            <li>Закажите профессиональный перевод</li>
            <li>Перевод в 1 клик</li>
            <li>Более 20 поддерживаемых языков</li>
            <li>и многое другое</li>
        </ul>

    </div>
    <div class="new-project__form">
        <form class="site__form" method="post" action="{{route('main.account.post-add-project')}}" novalidate>
            <fieldset>
                <label for="name-project">Название проекта</label>
                <input type="text" id="name-project" required/>
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
                <label for="link-project">Ссылка на проект</label>
                <input type="text" id="link-project" required/>
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
                <label>Основной язык проекта</label>
                <div class="new-project__question">
                    <span></span>
                    <div class="new-project__question-text">
                        В случае если вы имеете файл локализации. Мы применим инструменты перевода только к загруженным файлам локализации. Ознакомьтесь с
                        <a class="new-project__question-link" href="#">поддерживаемыми форматами</a>
                        файлов локализаций.
                    </div>
                </div>
                <div class="discount__selects-language " data-language='{{getLanguagesJson()}}'>
                    <div class="discount__language-wrapper">
                        <select name="lang_1" id="lang_1"  required>
                            <option value="0">Выберите язык</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <fieldset class="discount__language">
                <label>Перевести проект на язык</label>
                <div class="new-project__question">
                    <span></span>
                    <div class="new-project__question-text">
                        В случае если вы имеете файл локализации. Мы применим инструменты перевода только к загруженным файлам локализации. Ознакомьтесь с
                        <a class="new-project__question-link" href="#">поддерживаемыми форматами</a>
                        файлов локализаций.
                    </div>
                </div>
                <div class="discount__selects-language discount__selects-language_2" data-language='{{getLanguagesJson()}}'>

                    <div class="discount__language-wrapper">
                        <select name="lang_1" id="lang_3" required>
                            <option value="0">Выберите язык</option>
                        </select>
                    </div>
                    <a href="#" class="discount__languadge-add">Добавить направление перевода</a>

                </div>
            </fieldset>
            <fieldset class="new-project__check">
                <label><input type="checkbox" value="1" name="project__check" id="new-project__check-val"><span class="new-project__checked"></span><span class="new-project__check-title">У меня есть файл перевода (локализации) проекта</span></label>
            </fieldset>
            <button class="btn btn_2">
                <span>Создать проект</span>
            </button>
        </form>

    </div>
</div>
@stop