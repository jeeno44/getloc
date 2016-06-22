<div style="padding: 10px;">
    <a class="hide-history" href="#" style="float: right">{{trans('account.t_close')}}</a>
    <h3>{{trans('account.t_history_block')}}</h3>
    <div style="width: 100%">
        <div style="width: 5%; display: inline-block">№</div>
        <div style="width: 35%; display: inline-block">{{trans('account.t_history_text')}}</div>
        <div style="width: 35%; display: inline-block">{{trans('account.t_history_type')}}</div>
        <div style="width: 20%; display: inline-block">{{trans('account.t_history_date')}}</div>
    </div>
    @forelse($history as $key => $item)
        <div style="width: 100%">
            <div style="width: 5%; display: inline-block">{{$key + 1}}</div>
            <div style="width: 35%; display: inline-block">{{$item->text}}</div>
            <div style="width: 35%; display: inline-block">{{$item->translate->type->name}}</div>
            <div style="width: 20%; display: inline-block">{{date('d.m.Y H:i', strtotime($item->created_at))}}</div>
        </div>
    @empty
        <p>{{trans('account.t_history_block_empty')}}</p>
    @endforelse
</div>
