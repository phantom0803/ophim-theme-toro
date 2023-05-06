@if ($paginator->hasPages())
    <nav class="wp-pagenavi">
        <div class="nav-links">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
            @else
                <a class="page-link" title="Trang trước" href="{{ $paginator->previousPageUrl() }}"><i class="fa-arrow-left"></i></a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <a class="page-link disabled" href="#">{{ $element }}</a>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a class="page-link current" title="Trang {{$page}}" href="#">{{$page}}</a>
                        @else
                            <a class="page-link" title="Trang {{$page}}" href="{{$url}}"> {{$page}}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="page larger" title="Trang tiếp" href="{{ $paginator->nextPageUrl() }}"><i class="fa-arrow-right"></i></a>
            @else
            @endif
        </div>
    </nav>
@endif
