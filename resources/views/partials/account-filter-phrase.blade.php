<div class="site__aside-slick">
    <h2 class="site__aside-title">{{trans('account.filters')}}</h2>
    <form action="{{URL::route('main.account.setFilter')}}" method="POST">
    <input type="hidden" name="view_page" value="{{$tab_name}}" />

    <div id="block_page_title" class="filter_page_title" style="max-height: 250px; overflow: auto;">

    </div>
    <form action="" class="site__form">
        <fieldset>
            <input type="text" id="search_page" name="search_page" class="bordered" style="width: 100%; height: 40px; border-radius: 5px; margin-bottom: 10px;" />
        </fieldset>
    </form>



    {{--<div id="filter_page_site_wrap" class="filter_page_site_wrap">--}}
        {{--<div class="selected_for_title_wrap b-r_5">--}}
            {{--<div class="selected_for_title_item bordered">http://sad.andrey-malygin.ru/zanyatiya-v-detskom-sadu/<span class="remove_item">✕</span></div>--}}
            {{--<div class="selected_for_title_item bordered">http://sad.andrey-malygin.ru/zanyatiya-v-detskom-sadu/<span class="remove_item">✕</span></div>--}}
            {{--<div class="selected_for_title_item bordered">http://sad.andrey-malygin.ru/zanyatiya-v-detskom-sadu/<span class="remove_item">✕</span></div>--}}
            {{--<div class="selected_for_title_item bordered">http://sad.andrey-malygin.ru/zanyatiya-v-detskom-sadu/<span class="remove_item">✕</span></div>--}}
            {{--<div class="selected_for_title_item bordered">http://sad.andrey-malygin.ru/zanyatiya-v-detskom-sadu/<span class="remove_item">✕</span></div>--}}
        {{--</div>--}}
        {{--<input class="input_page_auto_complete bordered" type="text" data-site-id="{{ Session::get('projectID') }}" data-language-id="{{ Session::get('filter')['languageID'] }}" id="input_page_auto_complete" name="input_page_auto_complete" placeholder="Фильтр по страницам">--}}
        {{--<ul class="found_for_title_wrap b-r_5">--}}
            {{--<li class="found_for_title_item">http://sad.andrey-malygin.ru/zanyatiya-v-detskom-sadu/</li>--}}
            {{--<li class="found_for_title_item">http://sad.andrey-malygin.ru/zanyatiya-v-detskom-sadu/</li>--}}
            {{--<li class="found_for_title_item">http://sad.andrey-malygin.ru/zanyatiya-v-detskom-sadu/</li>--}}
            {{--<li class="found_for_title_item">http://sad.andrey-malygin.ru/zanyatiya-v-detskom-sadu/</li>--}}
        {{--</ul>--}}
    {{--</div>--}}
{{--{{ dd($filter) }}--}}
    <div class="site__aside-filter">
        <span>{{trans('account.langs')}}</span>
        @foreach ($filter['menu']['langs'] as $lang)
        <div class="nice-radio" @if ($filterDef != 1) style="display: block;" @endif>
            <input type="radio" value="{{$lang->id}}" name="filter[languageID]" id="lang_{{$lang->id}}" @if ($lang->id == $filter['menu']['active_lang']) checked @endif>
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