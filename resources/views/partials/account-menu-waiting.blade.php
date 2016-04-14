<div class="site__aside-menu">
    <a @if (Request::is('account/widget')) class="active" @endif href="{{ URL::route('main.account.widget') }}">{{trans('account.widget')}}</a>
</div>