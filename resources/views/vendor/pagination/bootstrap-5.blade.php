@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center" style="gap: 5px;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link border rounded px-3 py-1" style="color: #777; border-color: #ddd; background: transparent;">‹</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link border rounded px-3 py-1" href="{{ $paginator->previousPageUrl() }}" rel="prev" style="color: #555; border-color: #ddd; background: transparent;">‹</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link border rounded px-3 py-1" style="color: #777; border-color: #ddd; background: transparent;">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link border rounded px-3 py-1" style="color: #000; font-weight: bold; border-color: #bbb; background: transparent;">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link border rounded px-3 py-1" href="{{ $url }}" style="color: #555; border-color: #ddd; background: transparent;">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link border rounded px-3 py-1" href="{{ $paginator->nextPageUrl() }}" rel="next" style="color: #555; border-color: #ddd; background: transparent;">›</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link border rounded px-3 py-1" style="color: #777; border-color: #ddd; background: transparent;">›</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
