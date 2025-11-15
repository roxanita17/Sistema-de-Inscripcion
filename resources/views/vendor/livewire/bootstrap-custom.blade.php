@if ($paginator->hasPages())
    <div class="d-flex flex-column align-items-center mt-4">
        {{-- Botones de paginación --}}
        <nav aria-label="Paginación de registros">
            <ul class="pagination">
                {{-- Botón anterior --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <button type="button" class="page-link" wire:click="previousPage" wire:loading.attr="disabled" rel="prev">&laquo;</button>
                    </li>
                @endif

                {{-- Números de página --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <button type="button" class="page-link" wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled">{{ $page }}</button>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Botón siguiente --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <button type="button" class="page-link" wire:click="nextPage" wire:loading.attr="disabled" rel="next">&raquo;</button>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;</span>
                    </li>
                @endif
            </ul>
        </nav>

        {{-- Información de registros --}}
        <div class="pagination-info mt-2 text-muted">
            Mostrando <span>{{ $paginator->firstItem() ?? 0 }}</span>
            a <span>{{ $paginator->lastItem() ?? 0 }}</span>
            de <span>{{ $paginator->total() }}</span> registros
        </div>
    </div>
@endif