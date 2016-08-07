@if(Auth::check())
    @foreach(Auth::user()->sites()->where('count_words', '>', 0)->get() as $site)
        <div class="popup__content popup__unavailable popup__del{{$site->id}}">
            <a href="#" class="popup__close"></a>
            <h2 class="site__title site__title_center">{{trans('account.t_sproject_remove_project')}} {{$site->name}}</h2>
                <span style="display: block;text-align: center">
                    <a class="btn btn_8 btn_blue" href="/delete/{{$site->id}}">{{trans('account.t_sproject_remove')}}</a>
                </span>
        </div>
    @endforeach
@endif