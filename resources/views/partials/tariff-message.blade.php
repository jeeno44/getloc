<div class="other-tariff">
    <h2 class="other-tariff__title">Необходим более крутой тариф</h2>
    <p>Сейчас в вашем тарифе {{$project->count_words}} фраз и {{$project->languages()->count()}} {{trans_choice('account.languages_count', $project->languages()->count())}}. А ваш тариф рассчитан на {{$project->subscription->count_words}} фраз и {{$project->subscription->count_languages}} {{trans_choice('account.languages_count', $project->subscription->count_languages)}}.</p>
</div>