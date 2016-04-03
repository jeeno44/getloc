@foreach($blocks as $key => $block)
    <li data-page-id="{{ $block->id }}" data-site-id="{{ $block->site_id }}" class="found_for_title found_for_title_item">{{ $block->url }}</li>
@endforeach