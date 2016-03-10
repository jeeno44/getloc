<div class="site__aside-slick">
    <h2 class="site__aside-title">{{trans('account.filters')}}</h2>
    <form action="{{URL::route('main.account.setFilter')}}" method="POST">
    <input type="hidden" name="view_page" value="{{$tab_name}}" />
    <div class="site__aside-filter">
        <span>{{trans('account.langs')}}</span>
        @foreach ($filter['menu']['langs'] as $lang)
        <div class="nice-radio" style="display: block;">
            <input type="radio" value="{{$lang->id}}" name="filter[languageID]" id="lang_{{$lang->id}}" @if ($lang->id == $filter['menu']['active_lang']) checked @endif>
            <label for="lang_{{$lang->id}}">{{$lang->name}}<span>{{$filter['stats']['proc'][$lang->id]}}%</span></label>
        </div>
        @endforeach
    </div>
    <div class="site__aside-filter">
        <span>{{trans('account.types_translates')}}</span>
        <div style="display: block;">
            <div class="nice-radio">
                <input type="radio" value="0" name="filter[typeID]" id="typeid_0"@if (!$filter['menu']['active_type']) checked @endif>
                <label for="typeid_0">{{trans('account.all')}}<span>{{$filter['stats']['all']}}</span></label>
            </div>
            @foreach ($filter['menu']['types'] as $type )
            <div class="nice-radio">
                <input type="radio" value="{{$type->id}}" name="filter[typeID]" id="typeid_{{$type->id}}"@if ($type->id == $filter['menu']['active_type']) checked @endif>
                <label for="typeid_{{$type->id}}">{{$type->name}}<span style="color: {{$filter['colors'][$type->id]['hex']}}">{{$filter['stats']['menu'][$type->id]}}</span></label>
            </div>
            @endforeach
        </div>
    </div>
    <div class="site__aside-filter">
        <input type="submit" name="clearFilter" value="Очистить фильтр" />
        <input type="submit" name="setFilter" value="Фильтровать" />
    </div>
    </form>
</div>