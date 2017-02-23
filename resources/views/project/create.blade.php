@extends('layouts.account')
@section('title') {{trans('account.t_create_project_title')}} @stop
@section('content')
<h1 class="site__title">{{trans('account.t_create_project_header')}}</h1>

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
            <li>{{trans('account.t_create_project_opt_1')}}</li>
            <li>{{trans('account.t_create_project_opt_2')}}</li>
            <li>{{trans('account.t_create_project_opt_3')}}</li>
            <li>{{trans('account.t_create_project_opt_4')}}</li>
            <li>{{trans('account.t_create_project_opt_5')}}</li>
            <li>{{trans('account.t_create_project_opt_6')}}</li>
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
                    <label class="site__label" for="name-project">{{trans('account.t_create_project_name_project')}}</label>
                    <input type="text" class="site__input" name="name" id="name-project" required>
                </div>
                <div class="new-project__question">
                    <span></span>
                    <div class="new-project__question-text">
                        {{trans('account.t_create_project_but1')}} 
                        <a class="new-project__question-link" href="#">{{trans('account.t_create_project_but2')}}</a> 
                        {{trans('account.t_create_project_but3')}}
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <div class="site__data-field">
                    <label class="site__label" for="link-project">{{trans('account.t_create_project_link_project')}}</label>
                    <input type="text" class="site__input" name="url" id="link-project" required>
                </div>
                <div class="new-project__question">
                    <span></span>
                    <div class="new-project__question-text">
                        {{trans('account.t_create_project_but1')}} 
                        <a class="new-project__question-link" href="#">{{trans('account.t_create_project_but2')}}</a>
                        {{trans('account.t_create_project_but3')}}
                    </div>

                </div>
            </fieldset>
            <fieldset class="discount__language">
                <!-- site__data-field -->
                <div class="site__data-field">
                    <label class="site__label">{{trans('account.t_create_project_general_lang')}}</label>
                    <!-- new-project__question -->
                    <div class="new-project__question">
                        <span></span>
                        <!-- new-project__question-text -->
                        <div class="new-project__question-text">
                            {{trans('account.t_create_project_but1')}}
                            <!-- new-project__question-link -->
                            <a class="new-project__question-link" href="#">{{trans('account.t_create_project_but2')}}</a>
                            <!-- /new-project__question-link -->
                            {{trans('account.t_create_project_but3')}}
                        </div>
                        <!-- /new-project__question-text -->
                    </div>
                    <!-- /new-project__question -->

                    <!-- options__selects-wrap -->
                    <div class="discount__selects-language " data-language='{{getLanguagesJson()}}'>
                        <!-- discount__language-wrapper -->
                        <div class="discount__language-wrapper">
                            <select name="language[]" id="lang_1">
                                <option value="0">{{trans('account.t_create_project_select_lang')}}</option>
                            </select>
                        </div>
                        <!-- /discount__language-wrapper -->
                    </div>
                    <!-- /site__data-field -->
                </div>
                <!-- /discount__selects-language -->
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
</div>
@stop