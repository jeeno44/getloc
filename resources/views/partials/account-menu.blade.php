<div class="site__aside-menu">
    <a @if (Request::is('account') or Request::is('account/overview'))class="active" @endif href="{{ URL::route('main.account.overview') }}">{{trans('account.overviewProject')}}</a>
    <a @if (Request::is('account/languages') or Request::is('account/add_language')) class="active" @endif href="{{ URL::route('main.account.languages') }}">{{trans('account.languages')}}</a>
    <a @if (Request::is('account/pages')) class="active" @endif href="{{ URL::route('main.account.pages') }}">{{trans('account.pagesProject')}}</a>
    <a @if (Request::is('account/phrase') or Request::is('account/phrase/*')) class="active" @endif href="{{ URL::route('main.account.phrase') }}">{{trans('account.translatePhrases')}}</a>
    <a @if (Request::is('account/widget')) class="active" @endif href="{{ URL::route('main.account.widget') }}">{{trans('account.widget')}}</a>
    <a href="#">{{trans('account.settingsProject')}}</a>
    <a href="#" class="aside-menu__order">{{trans('account.myOrders')}} <span>2</span></a>
</div>