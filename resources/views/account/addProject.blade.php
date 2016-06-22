@extends('layouts.account')
@section('title') {{trans('account.t_add_project')}} @stop
@section('content') 
    <!-- site__title title_project -->
            <h1 class="site__title title_project">{{trans('account.t_create_project')}}</h1>
            <!-- site__title title_project -->

            <!-- new-project -->
            <div class="new-project">

                <!-- new-project -->
                <a class="new-project__skip" href="#">Пропустить работу помощника →</a>
                <!-- /new-project -->

                <!-- new-project__pros -->
                <div class="new-project__pros">

                    <!-- new-project__pic -->
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
                <!-- /new-project__pros -->

                <!-- new-project__form -->
                <div class="new-project__form">

                    <form class="site__form" method="get" action="php/form.php" novalidate>

                        <fieldset>
                            <label for="name-project">Название проекта</label>
                            <input type="text" id="name-project" required/>

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

                        </fieldset>

                        <fieldset>
                            <label for="link-project">Ссылка на проект</label>
                            <input type="text" id="link-project" required/>

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

                        </fieldset>

                        <fieldset class="discount__language">
                            <label>Основной язык проекта</label>

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
                            <div class="discount__selects-language " data-language='{
                                    "languages": [
                                        {
                                            "id": 1,
                                            "name": "Английский",
                                            "src": "img/icons-en.png"
                                        },
                                        {
                                            "id": 2,
                                            "name": "Русский",
                                            "src": "img/icons-en.png"
                                        },
                                        {
                                            "id": 3,
                                            "name": "Украинский",
                                            "src": "img/icons-ua.png"
                                        }
                                    ]
                                    }'>

                                <!-- discount__language-wrapper -->
                                <div class="discount__language-wrapper">

                                    <select name="lang_1" id="lang_1">
                                        <option value="0">Выберите язык</option>
                                    </select>

                                </div>
                                <!-- /discount__language-wrapper -->

                            </div>
                            <!-- /discount__selects-language -->

                        </fieldset>

                        <fieldset class="discount__language">
                            <label>Перевести проект на язык</label>

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
                            <div class="discount__selects-language discount__selects-language_2" data-language='{
                                    "languages": [
                                        {
                                            "id": 1,
                                            "name": "Английский",
                                            "src": "img/icons-en.png"
                                        },
                                        {
                                            "id": 2,
                                            "name": "Русский",
                                            "src": "img/icons-en.png"
                                        },
                                        {
                                            "id": 3,
                                            "name": "Украинский",
                                            "src": "img/icons-ua.png"
                                        }
                                    ]
                                    }'>

                                <!-- discount__language-wrapper -->
                                <div class="discount__language-wrapper">

                                    <select name="lang_1" id="lang_3">
                                        <option value="0">Выберите язык</option>
                                    </select>

                                </div>
                                <!-- /discount__language-wrapper -->

                                <a href="#" class="discount__languadge-add">Добавить направление перевода</a>

                            </div>
                            <!-- /discount__selects-language -->

                        </fieldset>

                        <!-- new-project__check -->
                        <fieldset class="new-project__check">
                            <label><input type="checkbox" value="1" name="project__check" id="new-project__check-val"><span class="new-project__checked"></span><span class="new-project__check-title">У меня есть файл перевода (локализации) проекта</span></label>
                        </fieldset>
                        <!-- /new-project__check -->

                        <!-- btn btn_project -->
                        <button class="btn btn_2">
                            <span>Создать проект</span>
                        </button>
                        <!-- /btn btn_project -->

                    </form>

                </div>
                <!-- /new-project__form -->

            </div>
@stop