@extends('layouts.account')
@section('title') Выберите проект @stop
@section('content')
    <div class="project-list__topic">
        <h2 class="site__title site__title_2">Мои проекты</h2>
        <a href="/account/add-project" class="project-list__add">Добавить новый проект</a>
    </div>
    @foreach($mySites as $site)
        <div class="project-list__item">
            <div class="project-list__title">
                @if($site->count_words == 0)
                    {{$site->url}} (сайт в обработке)
                    <div class="project-list__control">
                        <!--<a href="#">Настроить</a>-->
                        <a href="{{route('main.account.project-created', ['id' => $site->id])}}" class="project-list">Код для вставки</a>
                    </div>
                @else
                    <a href="{{URL::route('main.account.setProject', $site->id)}}" class="project-list__title-name"><b>{{$site->name}}</b> – {{$site->url}}</a>
                    <div class="project-list__control">
                        <!--<a href="#">Настроить</a>-->
                        <a class="project-list__control-delet popup__open" href="#" data-popup="del{{$site->id}}">Удалить</a>
                    </div>
                @endif

            </div>
            <div class="project-list__statistic">
                <span>{{$site->pages()->count()}}</span> страниц <span>{{$site->count_blocks}}</span> фраз
            </div>
            <div class="project-list__languages">
                <p>
                    Основной язык:
                    <span class="project-list__languages-item"><span class="flag" style="background-image: url('/icons/{{$site->language->icon_file}}')"></span> {{$site->language->original_name}}</span>
                </p>
                <p>
                    Языки перевода:
                    @foreach($site->languages as $lang)
                        <span class="project-list__languages-item"><span class="flag" style="background-image: url('/icons/{{$lang->icon_file}}')"></span> {{$lang->name}}</span>
                    @endforeach
                </p>
            </div>
            <div class="project-list__rate">
                @if($site->subscription)
                    <p><span>Тариф:</span> {{$site->subscription->plan->name}} – {{$site->subscription->month_cost}} р/мес.</p>
                    <?php $diff = round($site->subscription->deposit / ($site->subscription->month_cost / 30 ))?>
                    <p class="project-list__rate-term"><span>Осталось</span> {{$diff}} дней –
                        <a href="#" class="popup__open" data-popup="tt{{$site->id}}">Изменить</a>
                        <a href="{{route('main.billing.prolong', ['id' => $site->id])}}">Продлить</a>
                    </p>
                @else
                    <p><span>Тариф:</span> не выбран.</p>
                    <p class="project-list__rate-term">
                        @if($site->count_words > 0)
                            <a href="#" class="popup__open" data-popup="bb{{$site->id}}">Купить</a>
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
                    <h2 class="site__title site__title_center">Удаления проекта {{$site->name}}</h2>
                    <div style="text-align:center">
                        <a class="btn btn_8 btn_blue" href="{{route('main.account.project-remove', ['id' => $site->id])}}">Удалить</a>
                    </div>
                </div>

                <div class="popup__content popup__tariff popup__tt{{$site->id}}">
                    <a href="#" class="popup__close">close</a>
                    <div class="tariff-plan">
                        <h2 class="site__title site__title_center">Выбор тарифного плана</h2>
                        <div class="tariff-plan__items">
                            @foreach(\App\Plan::where('id', '!=', $site->planID)->where('enabled', 1)->get() as $plan)
                                <div class="tariff-plan__item">
                                    <h3 class="tariff-plan__name">{{$plan->name}}</h3>
                                    <div class="tariff-plan__cost">
                                        <div class="tariff-plan__cost-num">{{(int)$plan->cost}}</div>
                                        <span>рублей/месяц</span>
                                    </div>
                                    <div class="tariff-plan__possibility">
                                        <div>
                                            <span class="tariff-plan__possibility-num">{{$plan->count_languages}}</span> {{trans_choice('account.languages_count', $plan->count_languages)}} перевода
                                        </div>
                                        <div>
                                            <span class="tariff-plan__possibility-num">{{$plan->count_words}}</span> слов
                                        </div>
                                    </div>
                                    <form action="{{route('main.billing.upgrade-store')}}" method="post">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="site_id" value="{{$site->id}}">
                                        <input type="hidden" name="plan_id" value="{{$plan->id}}">
                                        <button type="submit" class="btn btn_9 btn_blue btn_full-width">Выбрать тариф</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                        <p>Выбери тот тариф, который больше всего подходит под нужды вашего сайта.</p>
                    </div>
                </div>
                <div class="popup__content popup__tariff popup__bb{{$site->id}}">
                    <a href="#" class="popup__close">close</a>
                    <div class="tariff-plan">
                        <h2 class="site__title site__title_center">Выбор тарифного плана</h2>
                        <div class="tariff-plan__items">
                            @foreach(\App\Plan::where('enabled', 1)->get() as $plan)
                                <form action="{{route('main.billing', ['id' => $site->id])}}" class="tariff-plan__item">
                                    <h3 class="tariff-plan__name">{{$plan->name}}</h3>
                                    <div class="tariff-plan__cost">
                                        <div class="tariff-plan__cost-num">{{(int)$plan->cost}}</div>
                                        <span>рублей/месяц</span>
                                    </div>
                                    <div class="tariff-plan__possibility">
                                        <div>
                                            <span class="tariff-plan__possibility-num">{{$plan->count_languages}}</span> {{trans_choice('account.languages_count', $plan->count_languages)}} перевода
                                        </div>
                                        <div>
                                            <span class="tariff-plan__possibility-num">{{$plan->count_words}}</span> слов
                                        </div>
                                    </div>
                                    <div class="site__select1">
                                        {!! Form::select('time', getDurations(), null) !!}
                                    </div>
                                    <input type="hidden" name="plan_id" value="{{$plan->id}}">
                                    <button type="submit" class="btn btn_9 btn_blue btn_full-width">Выбрать тариф</button>
                                </form>
                            @endforeach
                        </div>
                        <p>Выбери тот тариф, который больше всего подходит под нужды вашего сайта.</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@stop