<div class="site__aside-menu">
    <a @if (Request::is('account') or Request::is('account/overview'))class="active" @endif href="{{ URL::route('main.account.overview') }}">{{trans('account.overviewProject')}}</a>
    <a @if (Request::is('account/languages') or Request::is('account/add_language')) class="active" @endif href="{{ URL::route('main.account.languages') }}">{{trans('account.languages')}}</a>
    <a @if (Request::is('account/pages')) class="active" @endif href="{{ URL::route('main.account.pages') }}">{{trans('account.pagesProject')}}</a>
    <a @if (Request::is('account/phrase') or Request::is('account/phrase/*')) class="active" @endif href="{{ URL::route('main.account.phrase') }}">{{trans('account.translatePhrases')}}</a>
    <a @if (Request::is('account/images') or Request::is('account/images/*')) class="active" @endif href="/account/images">{{trans('account.images')}}</a>
    <a @if (Request::is('account/docs') or Request::is('account/docs/*')) class="active" @endif href="/account/docs">{{trans('account.docs')}}</a>
<!--<a @if (Request::is('account/widget')) class="active" @endif href="{{ URL::route('main.account.widget') }}">{{trans('account.widget')}}</a>-->
    <a href="{{route('main.billing.order')}}" class="aside-menu__order">{{trans('account.myOrders')}} {!!getCountOrders(Session::get('projectID'))!!}</a>
</div>