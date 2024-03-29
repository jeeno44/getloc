@if(Auth::check())
    @foreach(Auth::user()->sites()->where('count_words', '>', 0)->get() as $site)
        <div class="popup__content popup__unavailable popup__del{{$site->id}}">
            <a href="#" class="popup__close"></a>
            <h2 class="proj_delete">{{trans('account.t_sproject_remove_project')}} "{{$site->name}}" ?</h2>
                <span style="display: block;text-align: center">
                    <a class="btn btn_8 btn_blue" href="{{route('main.account.project-remove', ['id' => $site->id])}}">{{trans('account.t_sproject_remove')}}</a>
                </span>
        </div>



        <div class="popup__content popup__smcat{{$site->id}}">
            <div class="order-popup">
                <div class="order-popup__content">
                    <div class="discount__layout">
                        <h2 class="site__title">Экспортировать проект {{$site->name}} в SmartCat</h2>
                        <div class="discount__form-2 popup_form">
                            {!! Form::open(['url' => 'smartcat/'.$site->id]) !!}
                            <fieldset class="discount__language">
                                <label>Язык перевода *</label>
                                <div class="discount__selects-language" data-language='{{getLanguagesJson()}}'>
                                    <div class="discount__language-wrapper">
                                        <select name="lang2" id="lang2" required>
                                            <option value="0">{{trans('account.t_create_project_select_lang')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <input type="hidden" id="siteid" value="">
                            <button class="btn btn_discount">
                                <span>Экспортировать</span>
                            </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <button class="popup__close_2 popup__close"><span></span></button>
                </div>
            </div>
        </div>


        <div class="popup__content popup__xliff{{$site->id}}" style="background: none;">
            <div class="order-popup">
                <div class="order-popup__content">
                    <div class="discount__layout">
                        <h2 class="site__title">Скачать XLIFF {{$site->name}}</h2>
                        <div class="discount__form-2 popup_form">
                            {!! Form::open(['route' => ['main.xlfexport', $site->id, 0]]) !!}
                            <fieldset class="discount__language">
                                <label>Язык оригинала *</label>
                                <div class="discount__selects-language" data-language='{{getLanguagesJson()}}'>
                                    <div class="discount__language-wrapper">
                                        <select name="lang1" id="lang1" required>
                                            <option value="0">{{trans('account.t_create_project_select_lang')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="discount__language">
                                <label>Язык перевода *</label>
                                <div class="discount__selects-language" data-language='{{getLanguagesJson()}}'>
                                    <div class="discount__language-wrapper">
                                        <select name="lang2" id="lang2" required>
                                            <option value="0">{{trans('account.t_create_project_select_lang')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <input type="hidden" id="siteid" value="">
                            <button class="btn btn_discount">
                                <span>Скачать XLIFF</span>
                            </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <button class="popup__close" style="background: transparent; border:none;"><span></span></button>
                </div>
            </div>
        </div>


    @endforeach
@endif
