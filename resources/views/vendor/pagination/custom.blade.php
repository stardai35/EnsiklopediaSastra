@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="d-flex justify-content-center">
        <ul class="pagination" style="gap: 0.5rem; list-style: none; display: flex; align-items: center;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" style="background: #f0f0f0; color: #ccc; border: 1px solid #ddd; padding: 0.5rem 1rem; border-radius: 5px; cursor: not-allowed;">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" style="background: white; color: var(--primary-color); border: 1px solid var(--primary-color); padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer; transition: all 0.3s;">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link" style="background: transparent; color: #999; border: none; padding: 0.5rem 0.5rem; cursor: default;">
                            {{ $element }}
                        </span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link" style="background: var(--primary-color); color: white; border: 1px solid var(--primary-color); padding: 0.5rem 0.8rem; border-radius: 5px; font-weight: 600; min-width: 2.5rem; text-align: center;">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}" style="background: white; color: var(--primary-color); border: 1px solid #ddd; padding: 0.5rem 0.8rem; border-radius: 5px; cursor: pointer; transition: all 0.3s; min-width: 2.5rem; text-align: center; text-decoration: none;" onmouseover="this.style.background='var(--primary-color)'; this.style.color='white';" onmouseout="this.style.background='white'; this.style.color='var(--primary-color)';">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" style="background: white; color: var(--primary-color); border: 1px solid var(--primary-color); padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer; transition: all 0.3s;">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" style="background: #f0f0f0; color: #ccc; border: 1px solid #ddd; padding: 0.5rem 1rem; border-radius: 5px; cursor: not-allowed;">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>

    <style>
        .pagination {
            margin: 0;
            padding: 0;
        }

        .page-link:hover:not(.disabled) {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2);
        }

        .page-item.disabled .page-link {
            opacity: 0.6;
        }
    </style>
@endif
