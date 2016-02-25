    <ul id="main-menu" class="nav-main" >
        @foreach($adminMenuItems as $name => $item)
            @if (isset($item['items']) && is_array($item['items']))
                <li class="@if (strpos($currentUri, $item['uri']) !== false) active open @endif">
                    <a class="nav-submenu @if (strpos($currentUri, $item['uri']) !== false) active parent-active @endif" data-toggle="nav-submenu" href="#">
                        <i class="{{$item['icon']}} side-icon"></i>
                        <span class="title">&nbsp;{{$name}}
                        </span>
                    </a>
                    <ul>
                        @foreach($item['items'] as $sub_name => $sub_item)
                            <li class="">
                                <a href="/{!!$sub_item['uri']!!}" class="@if ($currentUri == $sub_item['uri']) active @endif">
                                    <i class="{{$sub_item['icon']}}"></i>
                                    <span class="title">&nbsp;{{$sub_name}}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @else
                <li>
                    <a href="/{!! $item['uri']!!}" class="@if ($currentUri == $item['uri']) active parent-active @endif">
                        <i class="{{$item['icon']}} side-icon"></i>
                        <span class="title">&nbsp;{{$name}}</span>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>