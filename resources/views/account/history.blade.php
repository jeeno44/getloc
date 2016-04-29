<div style="padding: 10px;">
    <a class="hide-history" href="#" style="float: right">Закрыть</a>
    <h3>История перевода</h3>
    <div style="width: 100%">
        <div style="width: 5%; display: inline-block">№</div>
        <div style="width: 35%; display: inline-block">Текст</div>
        <div style="width: 35%; display: inline-block">Тип</div>
        <div style="width: 20%; display: inline-block">Дата</div>
    </div>
    @forelse($history as $key => $item)
        <div style="width: 100%">
            <div style="width: 5%; display: inline-block">{{$key + 1}}</div>
            <div style="width: 35%; display: inline-block">{{$item->text}}</div>
            <div style="width: 35%; display: inline-block">{{$item->translate->type->name}}</div>
            <div style="width: 20%; display: inline-block">{{date('d.m.Y H:i', strtotime($item->created_at))}}</div>
        </div>
    @empty
        <p>История перевода фразы пуста</p>
    @endforelse
</div>
