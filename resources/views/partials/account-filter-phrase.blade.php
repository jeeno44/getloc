<div class="make-order" @if($costOrder == 0) style="display: none" @endif>
    <h2 class="make-order__title">Заказ на перевод</h2>
    <form action="/account/orders" method="get">
        <div class="site__align-items-justify">
            <div class="nice-check">
                <input type="checkbox" id="checkboxPhraseInOrder" value="" class="checkboxPhraseInOrder">
                <label for="checkboxPhraseInOrder">{{trans('account.phrasesInOrder')}}</label>
            </div>
            <span class="make-order__phrases site__align-right phrasesCount">{{ $phrasesInOrder }}</span>
        </div>
        <div class="make-order__total site__align-items-justify">
            <span>{{trans('account.costOrder')}}</span>
            <span class="make-order__total-price site__align-right costCount">{{ $costOrder }} Р</span>
        </div>
        <a class="btn btn_6 btn_full-width make-order-btn"  style="padding-top: 14px;"  href="/account/orders">Оформить заказ</a>
    </form>
</div>

<div class="site__aside-slick">
    <h2 class="site__aside-title">{{trans('account.filters')}}</h2>
    <form action="{{URL::route('main.account.setFilter')}}" method="POST">
    <input type="hidden" name="view_page" value="{{$tab_name}}" />

        <div class="site__aside-filter accordion">
            <span class="accordion__head">{{trans('account.langs')}}</span>
            <div class="accordion__content">
                @foreach ($filter['menu']['langs'] as $lang)
                    <div class="nice-radio" @if ($filterDef != 1) style="display: block;" @endif>
                        <input type="radio" value="{{$lang->id}}" name="filter[languageID]" id="lang_{{$lang->id}}" @if(isset($_GET['language_id']) && $_GET['language_id'] == $lang->id) checked @else  @if ($lang->id == $filter['menu']['active_lang']) checked @endif @endif>
                        <label for="lang_{{$lang->id}}"><span class="flag" style="background-image: url('/icons/{{$lang->icon_file}}')"></span>{{$lang->name}}<span id="lang_proc_{{$lang->id}}">{{$filter['stats']['proc'][$lang->id]}}%</span></label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="site__aside-filter accordion">
            <span class="accordion__head">Выбрать даты</span>
            <div class="accordion__content">
                <div class="choice-dates">
                    <div>
                        <label for="from">от</label>
                        <input class="site__input site__input_small datepicker date_filter_start" type="text" name="date_filter_start" id="date_filter_start">
                    </div>
                    <div>
                        <label for="to">до</label>
                        <input class="site__input site__input_small datepicker date_filter_end" type="text" name="date_filter_end" id="date_filter_end">
                    </div>
                </div>
            </div>
        </div>

        <div class="site__aside-filter accordion">
            <span class="accordion__head">{{trans('account.types_translates')}}</span>
            <div class="accordion__content">
                <div @if ($filterDef != 1) style="display: block;" @endif>
                    <div class="nice-radio">
                        <input type="radio" value="0" name="filter[typeID]" id="typeid_0"@if (!$filter['menu']['active_type']) checked @endif>
                        <label for="typeid_0">{{trans('account.all')}}<span id="cc_all">{{$filter['stats']['all']}}</span></label>
                    </div>
                    @foreach ($filter['menu']['types'] as $type )
                        <div class="nice-radio">
                            <input type="radio" value="{{$type->id}}" name="filter[typeID]" id="typeid_{{$type->id}}"@if ($type->id == $filter['menu']['active_type']) checked @endif>
                            <label for="typeid_{{$type->id}}">{{$type->name}}<span id="cc_id_{{$type->id}}" style="color: {{$filter['colors'][$type->id]['hex']}}">{{$filter['stats']['menu'][$type->id]}}</span></label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="site__aside-filter accordion">

            <span class="accordion__head">Страницы</span>
            <div class="accordion__content">
                <div class="search-pages" data-autocomplite="/account/pages/autocomplete/{{$site->id}}">
                    <div class="search-pages__fields">
                        <input class="site__input site__input_small search-pages__input" type="search" name="search-pages-field">
                    </div>
                    <div class="search-pages__chosen">
                        @if(!empty(Session::get('pages_url_'.$site->id, [])))
                            @foreach(Session::get('pages_url_'.$site->id, []) as $pageUrl)
                                <div class="search-pages__chosen-item">
                                    <div>{{$pageUrl}}</div>
                                    <a class="search-pages__chosen-delete" href="#"></a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

        </div>

    <a href="{{route('main.account.clear-filter')}}" class="btn btn_5">Очистить фильтр</a>
    </form>
</div>