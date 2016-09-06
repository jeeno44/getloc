@extends('layouts.account')
@section('title') {{trans('account.t_sproject_title')}} @stop
@section('content')
    <div class="project-list__topic">
        <h2 class="site__title site__title_2">{{trans('account.t_sproject_my_projects')}}</h2>
        <a href="{{route('main.account.add-project')}}" class="project-list__add">{{trans('account.t_sproject_add_new')}}</a>
    </div>
    @foreach($mySites as $site)
        <div class="project-list__item">
            <div class="project-list__title">
                @if($site->count_words == 0)
                    {{$site->url}}
                    @if($site->pages()->count() == 0)
                        {{trans('account.t_sproject_status_spider')}}
                    @else
                        {{trans('account.t_sproject_status_collect')}}
                    @endif
                    <div class="project-list__control">
                        <!--<a href="#">Настроить</a>-->
                        <a href="{{route('main.account.project-created', ['id' => $site->id])}}" class="project-list">{{trans('account.t_sproject_code_insert')}}</a>
                    </div>
                @else
                    <a href="{{URL::route('main.account.setProject', $site->id)}}" class="project-list__title-name"><b>{{$site->name}}</b> – {{$site->url}}</a>
                    <div class="project-list__control">
                        <!--<a href="#">Настроить</a>-->
                        <a class="project-list__control-delet popup__open" href="#" data-popup="del{{$site->id}}">{{trans('account.t_sproject_remove')}}</a>
                    </div>
                @endif

            </div>
            <div class="project-list__statistic">
                <span>{{$site->pages()->count()}}</span> {{trans('account.t_sproject_pages')}} <span>{{$site->count_blocks}}</span> {{trans('account.t_sproject_phrases')}}
            </div>
            <div class="project-list__languages">
                <p>
                    {{trans('account.t_sproject_general_lang')}}:
                    <span class="project-list__languages-item"><span class="flag" style="background-image: url('/icons/{{$site->language->icon_file}}')"></span> {{$site->language->original_name}}</span>
                </p>
                <p>
                    {{trans('account.t_sproject_langs_translates')}}:
                    @foreach($site->languages as $lang)
                        <span class="project-list__languages-item"><span class="flag" style="background-image: url('/icons/{{$lang->icon_file}}')"></span> {{$lang->name}}</span>
                    @endforeach
                </p>
            </div>
            <div class="project-list__rate">
                @if($site->subscription)
                    <p><span>{{trans('account.t_sproject_tarif')}}:</span> {{$site->subscription->plan->name}} – {{$site->subscription->month_cost}} {{trans('account.t_month_cost')}}.</p>
                    <?php $diff = round($site->subscription->deposit / ($site->subscription->month_cost / 30 ))?>
                    <p class="project-list__rate-term"><span>{{trans('account.t_sproject_time_die')}}</span> {{$diff}} {{trans('account.t_sproject_days')}} –
                        <a href="#" class="popup__open" data-popup="tt{{$site->id}}">{{trans('account.t_change')}}</a>
                        <a href="{{route('main.billing.prolong', ['id' => $site->id])}}">{{trans('account.t_cont')}}</a>
                    </p>
                @else
                    <p><span>{{trans('account.t_sproject_tarif')}}:</span> {{trans('account.t_sproject_tarif_not_select')}}</p>
                    <p class="project-list__rate-term">
                        @if($site->count_words > 0)
                            <a href="#" class="popup__open" data-popup="bb{{$site->id}}">{{trans('account.t_buy')}}</a>
                        @endif
                    </p>
                @endif
            </div>
        </div>
    @endforeach
    <div class="popup">
        <div class="popup__wrap">
            @foreach($mySites as $site)

                <div class="popup__content popup__unavailable popup__del{{$site->id}}">
                    <a href="#" class="popup__close">close</a>
                    <h2 class="site__title site__title_center">{{trans('account.t_sproject_remove_project')}} {{$site->name}}</h2>
                    <div style="text-align:center">
                        <a class="btn btn_8 btn_blue" href="{{route('main.account.project-remove', ['id' => $site->id])}}">{{trans('account.t_sproject_remove')}}</a>
                    </div>
                </div>

                <div class="popup__content popup__tariff popup__tt{{$site->id}}">
                    <a href="#" class="popup__close">close</a>
                    <div class="tariff-plan">
                        <h2 class="site__title site__title_center">{{trans('account.t_select_tarif')}}</h2>
                        <div class="tariff-plan__items">
                            @foreach(\App\Plan::where('id', '!=', $site->planID)->where('enabled', 1)->get() as $plan)
                                <div class="tariff-plan__item">
                                    <h3 class="tariff-plan__name">{{$plan->name}}</h3>
                                    <div class="tariff-plan__cost">
                                        <div class="tariff-plan__cost-num">{{(int)$plan->cost}}</div>
                                        <span>{{trans('account.t_month_cost2')}}</span>
                                    </div>
                                    <div class="tariff-plan__possibility">
                                        <div>
                                            <span class="tariff-plan__possibility-num">{{$plan->count_languages}}</span> {{trans_choice('account.languages_count', $plan->count_languages)}} {{trans('account.t_overview_trans')}}
                                        </div>
                                        <div>
                                            <span class="tariff-plan__possibility-num">{{$plan->count_words}}</span> {{trans('account.t_overview_words')}}
                                        </div>
                                    </div>
                                    <form action="{{route('main.billing.upgrade-store')}}" method="post">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="site_id" value="{{$site->id}}">
                                        <input type="hidden" name="plan_id" value="{{$plan->id}}">
                                        <button type="submit" class="btn btn_9 btn_blue btn_full-width">{{trans('account.t_overview_select_tarif')}}</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                        <p>{{trans('account.t_overview_select_tarif_recommend')}}</p>
                    </div>
                </div>
                <div class="popup__content popup__tariff popup__bb{{$site->id}}">
                    <a href="#" class="popup__close">close</a>
                    <div class="tariff-plan">
                        <h2 class="site__title site__title_center">{{trans('account.t_select_tarif')}}</h2>
                        <div class="tariff-plan__items">
                            @foreach(\App\Plan::where('enabled', 1)->get() as $plan)
                                <form action="{{route('main.billing', ['id' => $site->id])}}" class="tariff-plan__item">
                                    <h3 class="tariff-plan__name">{{$plan->name}}</h3>
                                    <div class="tariff-plan__cost">
                                        <div class="tariff-plan__cost-num">{{(int)$plan->cost}}</div>
                                        <span>{{trans('account.t_month_cost2')}}</span>
                                    </div>
                                    <div class="tariff-plan__possibility">
                                        <div>
                                            <span class="tariff-plan__possibility-num">{{$plan->count_languages}}</span> {{trans_choice('account.languages_count', $plan->count_languages)}} {{trans('account.t_overview_trans')}}
                                        </div>
                                        <div>
                                            <span class="tariff-plan__possibility-num">{{$plan->count_words}}</span> {{trans('account.t_overview_words')}}
                                        </div>
                                    </div>
                                    <div class="site__select1">
                                        {!! Form::select('time', getDurations(), null) !!}
                                    </div>
                                    <input type="hidden" name="plan_id" value="{{$plan->id}}">
                                    <button type="submit" class="btn btn_9 btn_blue btn_full-width">{{trans('account.t_overview_select_tarif')}}</button>
                                </form>
                            @endforeach
                        </div>
                        <p>{{trans('account.t_overview_select_tarif_recommend')}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@stop