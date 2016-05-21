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
                        <a href="{{route('main.account.project-remove', ['id' => $site->id])}}" class="project-list__control-delete">Удалить</a>
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
                        <a href="{{route('main.billing.upgrade', ['id' => $site->id])}}">Изменить</a>
                        <a href="{{route('main.billing.prolong', ['id' => $site->id])}}">Продлить</a>
                    </p>
                @else
                    <p><span>Тариф:</span> не выбран.</p>
                    <p class="project-list__rate-term">
                        <a href="{{route('main.billing', ['id' => $site->id])}}">Купить</a>
                    </p>
                @endif
            </div>
        </div>
    @endforeach

@stop