@props(['paginator'])

@php
    $elements = $paginator->elements();
@endphp

@if ($paginator->hasPages())
    <div class="pagination-wrapper">
        <nav class="pagination-container" aria-label="Paginación">
            <ul class="pagination">
                {{-- Anterior --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo; Anterior</span>
                    </li>
                @else
                    <li class="page-item">
                        <button type="button" class="page-link" 
                                wire:click="gotoPage({{ $paginator->currentPage() - 1 }})">
                            &laquo; Anterior
                        </button>
                    </li>
                @endif

                {{-- Páginas --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="page-item disabled">
                            <span class="page-link">{{ $element }}</span>
                        </li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <button type="button" class="page-link" 
                                            wire:click="gotoPage({{ $page }})">
                                        {{ $page }}
                                    </button>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Siguiente --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <button type="button" class="page-link" 
                                wire:click="gotoPage({{ $paginator->currentPage() + 1 }})">
                            Siguiente &raquo;
                        </button>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">Siguiente &raquo;</span>
                    </li>
                @endif
            </ul>
        </nav>

        <div class="pagination-info">
            Mostrando
            <span>{{ $paginator->firstItem() ?? 0 }}</span>
            a
            <span>{{ $paginator->lastItem() ?? 0 }}</span>
            de
            <span>{{ $paginator->total() }}</span>
            registros
        </div>
    </div>
@endif