{{-- resources/views/components/pagination.blade.php --}}
@props(['paginator'])

@if ($paginator->hasPages())
    <div class="d-flex flex-column align-items-center mt-4">
        {{--Botones de paginación --}}
        <nav aria-label="Paginación de registros">
            <ul class="pagination">
                {{-- Botón anterior --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link ajax-page" href="{{ $paginator->previousPageUrl() }}" data-page="{{ $paginator->currentPage() - 1 }}" rel="prev">&laquo;</a>
                    </li>
                @endif

                {{-- Números de página --}}
                @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                        <a class="page-link ajax-page" href="{{ $url }}" data-page="{{ $page }}">{{ $page }}</a>
                    </li>
                @endforeach

                {{-- Botón siguiente --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link ajax-page" href="{{ $paginator->nextPageUrl() }}" data-page="{{ $paginator->currentPage() + 1 }}" rel="next">&raquo;</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;</span>
                    </li>
                @endif
            </ul>
        </nav>

        {{--Información de registros --}}
        <div class="pagination-info mt-2 text-muted">
            Mostrando <span>{{ $paginator->firstItem() ?? 0 }}</span>
            a <span>{{ $paginator->lastItem() ?? 0 }}</span>
            de <span>{{ $paginator->total() }}</span> registros
        </div>
    </div>
@endif
