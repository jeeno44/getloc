<div class="site__aside-menu">
    @foreach($items as $parentName => $children)
        <a href="#" class="account-menu-parent">{!! $parentName !!}</a>
        <div class="account-menu-children">
            @foreach($children as $name => $menu)
                <a href="/{{$menu[0]}}" class="account-menu-item @if(strpos($path, $menu[0]) !== false) active @endif {{$menu[1]}}">{{$name}}</a>
            @endforeach
        </div>
    @endforeach
</div>