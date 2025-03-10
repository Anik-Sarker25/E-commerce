<ul class="breadcrumb">
    @foreach ($items as $key => $item)
        <li class="breadcrumb-item text-capitalize {{ $loop->last ? 'active' : '' }}">
            @if (!$loop->last)
                <a href="{{ $item['url'] }}">{{ $item['title'] }}</a>
            @else
                {{ $item['title'] }}
            @endif
        </li>
    @endforeach
</ul>
