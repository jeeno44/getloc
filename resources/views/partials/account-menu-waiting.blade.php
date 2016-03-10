<div class="site__aside-menu">
    <a @if (Request::is('account/widget')) class="active" @endif href="{{ URL::route('main.account.widget') }}">{{trans('account.widget')}}</a>
    <a href="#">{{trans('account.settingsProject')}}</a>
    <a href="#" class="aside-menu__order">{{trans('account.myOrders')}} <span>2</span></a>
</div>