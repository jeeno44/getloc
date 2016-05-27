<div class="other-tariff">
    <h2 class="other-tariff__title">Необходим более крутой тариф!</h2>
    <p>Сейчас в вашем тарифе {{$project->count_words}} слов и {{$project->languages()->count()}} {{trans_choice('account.languages_count', $project->languages()->count())}}. Но ваш тариф рассчитан на {{$project->subscription->count_words}} слов и {{$project->subscription->count_languages}} {{trans_choice('account.languages_count', $project->subscription->count_languages)}}.</p>
    <p>Слова сверх тарифного плана не отображаются на вашем проекте. Необходимо сменить тарифный план.</p>
    <a class="other-tariff__change popup__open" href="#" data-popup="tt" class="inside-content__tune-link popup__open">Сменить тарифный план</a>
</div>