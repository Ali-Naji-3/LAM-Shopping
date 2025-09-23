@if ($paginator->hasPages())
    <nav style="display: flex; align-items: center;">
        <ul class="pagination mb-0" style="display: flex; align-items: center; list-style: none; margin: 0; padding: 0; gap: 2px;">
            {{-- Pagination Elements Only (No Previous/Next) --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" style="margin: 0;">
                        <span class="page-link" style="background: #f8f9fa; border: 1px solid #dee2e6; color: #6c757d; padding: 8px 12px; border-radius: 4px; font-size: 14px;">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" style="margin: 0;">
                                <span class="page-link" style="background: #007bff; border: 1px solid #007bff; color: white; padding: 8px 12px; border-radius: 4px; font-size: 14px; font-weight: 500;">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item" style="margin: 0;">
                                <a class="page-link" href="{{ $url }}" style="background: white; border: 1px solid #dee2e6; color: #007bff; padding: 8px 12px; border-radius: 4px; font-size: 14px; text-decoration: none; transition: all 0.2s;">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Arrow Only --}}
            @if ($paginator->hasMorePages())
                <li class="page-item" style="margin: 0;">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" style="background: white; border: 1px solid #dee2e6; color: #007bff; padding: 8px 12px; border-radius: 4px; font-size: 14px; text-decoration: none;">&gt;</a>
                </li>
            @else
                <li class="page-item disabled" style="margin: 0;">
                    <span class="page-link" style="background: #f8f9fa; border: 1px solid #dee2e6; color: #6c757d; padding: 8px 12px; border-radius: 4px; font-size: 14px;">&gt;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
