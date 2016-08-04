<div class="other-tariff">
    <h2 class="other-tariff__title">{{trans('account.t_tarif_title')}}</h2>
    <p>{{trans('account.t_tarif_cur_text')}} {{$project->count_words}} {{trans('account.t_tarif_word_and')}} {{$project->languages()->count()}} {{trans_choice('account.languages_count', $project->languages()->count())}}. {{trans('account.t_tarif_but')}} {{$project->subscription->count_words}} {{trans('account.t_tarif_word_and')}} {{$project->subscription->count_languages}} {{trans_choice('account.languages_count', $project->subscription->count_languages)}}.</p>
    <p>{{trans('account.t_tarif_message_but')}}</p>
    <a class="other-tariff__change popup__open" href="#" data-popup="tt" class="inside-content__tune-link popup__open">{{trans('account.t_tarif_change')}}</a>
</div>