@extends('layouts.account')
@section('title') {{trans('account.t_create_project_title')}} @stop
@section('content')
    <aside class="site__aside">
        {!! accountMenu() !!}
    </aside>
    <div class="inside-content">
        <h1 class="site__title">{{trans('account.t_create_project_header')}}</h1>

        <div class="new-project">
            <!-- new-project
            <a class="new-project__skip" href="#">Пропустить работу помощника →</a>
            /new-project -->
            <!-- new-project__pros -->

            <!-- /new-project__pros -->
            <!-- new-project__form -->
            <div class="new-project__form" style="width: 100%">
                @if($errors->any())
                    @foreach($errors->all() as $e)
                        <div style="background: red;color: white">{{$e}}</div>
                    @endforeach
                @endif
                <form class="site__form" method="post" action="{{route('main.account.post-add-project')}}" novalidate>
                    <fieldset>
                        <div class="site__data-field">
                            <label class="site__label" for="name-project">{{trans('account.t_create_project_name_project')}}</label>
                            <input type="text" class="site__input" name="name" id="name-project" required>
                        </div>
                        <div class="new-project__question">
                            <span></span>
                            <div class="new-project__question-text">
                                Введите произвольное название для вашего проекта
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="site__data-field">
                            <label class="site__label" for="link-project">{{trans('account.t_create_project_link_project')}}</label>
                            <select name="protocol" id="" data-width="20%">
                                <option value="http://">http://</option>
                                <option value="https://">https://</option>
                            </select>
                            <input type="text" class="site__input" name="url" id="link-project" required style="width: 78%">
                        </div>
                        <div class="new-project__question">
                            <span></span>
                            <div class="new-project__question-text">
                                Ссылка на сайт проекта
                            </div>

                        </div>
                    </fieldset>
                    <fieldset>
                        <!-- site__data-field -->
                        <div class="site__data-field">
                            <label class="site__label">{{trans('account.t_create_project_general_lang')}}</label>
                            <select class="select2" name="language[]">
                                @foreach($languages as $lang)
                                    <option value="{{$lang['id']}}">{{$lang['name']}}</option>
                                @endforeach
                            </select>
                            <div class="new-project__question">
                                <span></span>
                                <div class="new-project__question-text">
                                    Основной язык сайта
                                </div>
                            </div>
                        </div>
                    </fieldset>


                    <!-- nice-check
                    <fieldset class="nice-check new-project__form-check">
                        <input type="checkbox" value="1" name="project__check" id="new-project1">
                        <label for="new-project1">
                            У меня есть файл перевода (локализации) проекта
                        </label>
                    </fieldset>-->
                    <fieldset class="nice-check new-project__form-check">
                        <input type="checkbox" value="1" name="protected" id="new-project2">
                        <label for="new-project2">
                            {{trans('account.t_create_project_firewall')}}
                        </label>
                    </fieldset>
                    <!-- /nice-check -->
                    <!-- btn  -->
                    <button class="btn btn_9 btn_blue">{{trans('account.t_create_project_create')}}</button>
                    <!-- /btn  -->
                </form>
            </div>
            <!-- /new-project__form -->

            <div class="new-project__pros" style="width: 100%; margin-top: 40px">
                <!-- new-project__pic -->
                <div class="new-project__pic" style="background-image: url(/assets/img/account/create-pic.png)"></div>
                <!-- new-project__list -->
                <ul class="new-project__list">
                    <li>{{trans('account.t_create_project_opt_1')}}</li>
                    <li>{{trans('account.t_create_project_opt_2')}}</li>
                    <li>Экспорт контента в XLIFF</li>
                    <li>Внедрение перевода на сайт</li>
                </ul>
                <!-- /new-project__list -->
            </div>
        </div>
    </div>

@stop