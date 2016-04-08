<div class="site__aside-slick">
    <h2 class="site__aside-title">{{trans('account.filters')}}</h2>
    <form action="{{URL::route('main.account.setFilter')}}" method="POST">
    <input type="hidden" name="view_page" value="{{$tab_name}}" />


    <div  style="margin-bottom: 15px;" class="date_filter_wrap">
        <input type="text" name="date_filter" id="date_filter" value="" class="date_filter">
        <button class="button_search_text">поиск</button>
    </div>

    <div class="search_text_wrap" style="margin-bottom: 10px;">
        <input type="text" class="search_text">
        <button class="button_search_text">поиск</button>
    </div>


    <div  style="margin-bottom: 15px;" class="phrases_in_order">
        <input type="checkbox" name="checkboxPhraseInOrder" id="checkboxPhraseInOrder" value="" class="checkboxPhraseInOrder">
        <label for="checkboxPhraseInOrder">{{trans('account.phrasesInOrder')}} <span class="phrasesCount">{{ $phrasesInOrder }}</span></label>
    </div>

    <div id="block_page_title" class="filter_page_title" style="max-height: 250px; overflow: auto;">
{{--        {{ $pages_url = Session::get('pages_url') }}--}}
{{--        {{ dd(Session::get('pages_url')) }}--}}
        @if(Session::get('pages_url') && Session::get('pages_url') != '')
            @foreach(explode(',', Session::get('pages_url')) as $page_url)
                <div class="selected_for_title_item bordered">{{ $page_url }}<span class="remove_item">✕</span></div>
            @endforeach
        @endif
    </div>
    <form action="" class="site__form">
        <fieldset>
            <input type="text" id="search_page" name="search_page" class="bordered" style="width: 100%; height: 40px; border-radius: 5px; margin-bottom: 10px;" />
        </fieldset>
    </form>

{{--{{ dd($filter) }}--}}
    <div class="site__aside-filter">
        <span>{{trans('account.langs')}}</span>
        @foreach ($filter['menu']['langs'] as $lang)
        <div class="nice-radio" @if ($filterDef != 1) style="display: block;" @endif>
            <input type="radio" value="{{$lang->id}}" name="filter[languageID]" id="lang_{{$lang->id}}" @if(isset($_GET['language_id']) && $_GET['language_id'] == $lang->id) checked @else  @if ($lang->id == $filter['menu']['active_lang']) checked @endif @endif>
            <label for="lang_{{$lang->id}}">{{$lang->name}}<span id="lang_proc_{{$lang->id}}">{{$filter['stats']['proc'][$lang->id]}}%</span></label>
        </div>
        @endforeach
    </div>
    <div class="site__aside-filter">
        <span>{{trans('account.types_translates')}}</span>
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

    <input type="submit" name="clearFilter" value="Очистить фильтр" />
    </form>
</div>