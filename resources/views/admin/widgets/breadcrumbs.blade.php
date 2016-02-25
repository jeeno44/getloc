<!--breadcrumbs start-->
<ol class="breadcrumb push-10-t">
    @foreach($breadcrumbs as $index => $crumb)
        @if (count($breadcrumbs) == $index + 1)
            <li class="active">{!! $crumb['name'] !!}</li>
        @else
            <li><a href="{{ url($crumb['link']) }}" class="text-white">{!! $crumb['name'] !!}</a></li>
        @endif
    @endforeach
</ol>
<!--breadcrumbs end-->
<style>
    .breadcrumb > li + li:before {
        color: rgba(255, 255, 255, 1);
    }
    .breadcrumb > li.active {
        color: rgba(255, 255, 255, 0.8);
    }
</style>