@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center" style="gap: 5px;">
            {{-- Tombol Previous --}}
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link border rounded px-3 py-1" href="{{ $paginator->previousPageUrl() }}" style="color: #555; border-color: #ddd; background: transparent;">‹</a>
            </li>

            {{-- Menampilkan halaman pertama --}}
            @if ($paginator->currentPage() > 4)
                <li class="page-item">
                    <a class="page-link border rounded px-3 py-1" href="{{ $paginator->url(1) }}" style="color: #555; border-color: #ddd; background: transparent;">1</a>
                </li>
                <li class="page-item disabled">
                    <span class="page-link border rounded px-3 py-1" style="color: #777; border-color: #ddd; background: transparent;">...</span>
                </li>
            @endif

            {{-- Menampilkan halaman sekitar halaman aktif --}}
            @foreach (range(max(1, $paginator->currentPage() - 3), min($paginator->lastPage(), $paginator->currentPage() + 3)) as $page)
                <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                    @if ($page == $paginator->currentPage())
                        <span class="page-link border rounded px-3 py-1" style="color: #000; font-weight: bold; border-color: #bbb; background: transparent;">{{ $page }}</span>
                    @else
                        <a class="page-link border rounded px-3 py-1" href="{{ $paginator->url($page) }}" style="color: #555; border-color: #ddd; background: transparent;">{{ $page }}</a>
                    @endif
                </li>
            @endforeach

            {{-- Menampilkan halaman terakhir jika jauh dari halaman aktif --}}
            @if ($paginator->currentPage() < $paginator->lastPage() - 3)
                <li class="page-item disabled">
                    <span class="page-link border rounded px-3 py-1" style="color: #777; border-color: #ddd; background: transparent;">...</span>
                </li>
                <li class="page-item">
                    <a class="page-link border rounded px-3 py-1" href="{{ $paginator->url($paginator->lastPage()) }}" style="color: #555; border-color: #ddd; background: transparent;">{{ $paginator->lastPage() }}</a>
                </li>
            @endif

            {{-- Tombol Next --}}
            <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link border rounded px-3 py-1" href="{{ $paginator->nextPageUrl() }}" style="color: #555; border-color: #ddd; background: transparent;">›</a>
            </li>
        </ul>
    </nav>
@endif
