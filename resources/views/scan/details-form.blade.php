@extends('layouts.scan')
@section('title') {{trans('account.t_billing_title_buy')}} @stop
@section('content')
    <div class="site__content site_inner">
        <!-- site__wrap -->
        <div class="site__wrap">
	        <div class="account-data">	
		        <h2 class="site__title">{{trans('account.contragent_data')}}</h2>
		        {!! Form::model($detail, ['route' => ['scan.billing.details-store'], 'class' => 'account-data__form']) !!}
				{!! csrf_field() !!}
		        <div class="account-data__main">
			        <div class="site__data-field">
			            <label class="site__label" for="name-project">{{trans('account.t_billing_fio')}}</label>
			            {!! Form::text('contact_name', null, ['class' => 'site__input', 'required']) !!}
			        </div>
			        <div class="site__data-field">
			            <label class="site__label" for="name-project">{{trans('account.t_billing_con_phone')}}</label>
			            {!! Form::text('contact_phone', null, ['class' => 'site__input','required']) !!}
					</div>
			        <div class="site__data-field">	
			            <label class="site__label" for="name-project">{{trans('account.t_billing_con_email')}}</label>
			            {!! Form::text('contact_email', null, ['class' => 'site__input','required']) !!}
					</div>
			         <div class="site__data-field">
			            <label class="site__label" for="name-project">{{trans('account.t_billing_fio_chief')}}</label>
			            {!! Form::text('company_principal_name', null, ['class' => 'site__input','required']) !!}
					</div>
			        <div class="site__data-field">
			            <label class="site__label" for="name-project">{{trans('account.t_billing_position_chief')}}</label>
			            {!! Form::text('company_principal_post', null, ['class' => 'site__input','required']) !!}
			        </div>
			        
			        		        
					<h2 class="site__title site__title_4">Данные организации</h2>
					<div class="site__data-field">
			            <label class="site__label" for="name-project">{{trans('account.t_billing_name_org')}}</label>
			            {!! Form::text('company_name', null, ['class' => 'site__input','required']) !!}
			        </div>
			        <div class="site__data-field">
				         <label class="site__label" for="name-project">{{trans('account.t_billing_ogrn')}}</label>
			            {!! Form::text('company_ogrn', null, ['class' => 'site__input','required']) !!}
			        </div>
			        <div class="site__data-field">
			            <label class="site__label" for="name-project">{{trans('account.t_billing_post_address')}}</label>
			            {!! Form::text('company_post_address', null, ['class' => 'site__input','required']) !!}
					</div>
			        <div class="site__data-field">	
			            <label class="site__label" for="name-project">{{trans('account.t_billing_ur_address')}}</label>
			            {!! Form::text('company_law_address', null, ['class' => 'site__input','required']) !!}
					</div>
			        <div class="site__data-field">
			            <label class="site__label" for="name-project">{{trans('account.t_billing_inn')}}</label>
			            {!! Form::text('company_inn', null, ['class' => 'site__input','required']) !!}
					</div>
			        <div class="site__data-field">
			            <label class="site__label" for="name-project">{{trans('account.t_billing_name_bank')}}</label>
			            {!! Form::text('company_bank_name', null, ['class' => 'site__input','required']) !!}
					</div>
			        <div class="site__data-field">
			            <label class="site__label" for="name-project">{{trans('account.t_billing_rs')}}</label>
			            {!! Form::text('company_bank_account', null, ['class' => 'site__input','required']) !!}
					</div>
					<div class="site__data-field">
			            <label class="site__label" for="name-project">Корреспондентский счет</label>
			            {!! Form::text('company_bank_account_ks', null, ['class' => 'site__input','required']) !!}
					</div>
			        <div class="site__data-field">
			            <label class="site__label" for="name-project">{{trans('account.t_billing_bik')}}</label>
			            {!! Form::text('company_bank_bik', null, ['class' => 'site__input','required']) !!}
					</div>
		        </div>
		
		
		        <button type="submit" class="btn btn_7 btn_blue account-data__save details-save">{{trans('account.save')}}</button>
		        {!! Form::close() !!}
    	</div>
        <!-- /site__wrap -->

    </div>
@stop