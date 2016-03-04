<div class="site__aside-slick">
    <h2 class="site__aside-title">{{trans('account.filters')}}</h2>
    <div class="site__aside-filter">
        <span>{{trans('account.langs')}}</span>
        @foreach ($menu['langs'] as $lang)
        <div class="nice-radio" style="display: block;">
            <input type="radio" name="language" id="lang_{{$lang->id}}" @if ($lang->id == $menu['active_lang']) checked @endif >
            <label for="lang_{{$lang->id}}">{{$lang->name}}<span>0%</span></label>
        </div>
        @endforeach
    </div>
    <div class="site__aside-filter">
        <span>{{trans('account.types_translates')}}</span>
        <div style="display: block;">
            <div class="nice-radio">
                <input type="radio" name="types" id="typeid_0">
                <label for="typeid_0">{{trans('account.all')}}<span>{{$stats['all']}}</span></label>
            </div>
            @foreach ($menu['types'] as $type )
            <div class="nice-radio" >
                <input type="radio" name="types" id="typeid_{{$type->id}}">
                <label for="typeid_{{$type->id}}">{{$type->name}}<span style="color: {{$colors[$type->id]['hex']}}">{{$stats['menu'][$type->id]}}</span></label>
            </div>
            @endforeach
        </div>
    </div>
</div>