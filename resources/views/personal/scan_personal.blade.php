@extends('layouts.scan')

@section('title') {{trans('account.t_personal_title')}} @stop
@section('content')
     <div class="site__content site_inner">
        <!-- site__wrap -->
        <div class="site__wrap">
	        <div class="account-data">
	            <h2 class="site__title">{{trans('account.t_personal')}}</h2>
	            <form action="" class="account-data__form" method="post">
	                {!! csrf_field() !!}
	                <div class="account-data__main">
	                    <div class="site__data-field">
	                        <label class="site__label" for="your-name">{{trans('account.t_personal_you_name')}}</label>
	                        <input type="text" class="site__input" name="visibility_name" id="your-name" value="{{Auth::user()->visibility_name}}">
	                    </div>
	                    <div class="site__data-field">
	                        <label class="site__label" for="your-email">{{trans('account.t_personal_email')}}</label>
	                        <input type="email" class="site__input" name="email" id="your-email" value="{{Auth::user()->email}}">
	                    </div>
	                </div>
	                <h2 class="site__title site__title_4">{{trans('account.t_personal_change_pass')}}</h2>
	                <div class="account-data__change-pass">
	                    <div class="site__data-field">
	                        <label class="site__label" for="new-pass">{{trans('account.t_personal_ins_new_pass')}}</label>
	                        <input type="password" class="site__input new-pass" name="password" id="new-pass">
	                    </div>
	                    <div class="site__data-field">
	                        <label class="site__label" for="repeat-pass">{{trans('account.t_personal_repeat_new_pass')}}</label>
	                        <input type="password" class="site__input repeat-pass" name="password_confirmation" id="repeat-pass">
	                    </div>
	                </div>
	                <button type="submit" class="btn btn_7 btn_blue account-data__save">{{trans('account.t_personal_save_change')}}</button>
	            </form>
	        </div>
    	</div>
        <!-- /site__wrap -->

    </div>
@stop