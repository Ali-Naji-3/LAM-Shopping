@props([
    'rating' => 0,
    'reviewCount' => 0,
    'interactive' => false,
    'size' => 'normal',
    'class' => ''
])

@php
    $sizeClasses = [
        'small' => 'text-sm',
        'normal' => 'text-base',
        'large' => 'text-lg'
    ];
    
    $iconSizes = [
        'small' => '14px',
        'normal' => '18px',
        'large' => '22px'
    ];
    
    $currentSize = $sizeClasses[$size] ?? $sizeClasses['normal'];
    $iconSize = $iconSizes[$size] ?? $iconSizes['normal'];
@endphp

<span class="rating {{ $interactive ? 'rating-interactive' : '' }} {{ $currentSize }} {{ $class }}" 
      data-rating="{{ $rating }}" 
      data-review-count="{{ $reviewCount }}"
      @if($interactive) data-interactive="true" @endif>
    <i class="icon-star"></i>
    <i class="icon-star"></i>
    <i class="icon-star"></i>
    <i class="icon-star"></i>
    <i class="icon-star"></i>
    <em>{{ $reviewCount }} {{ $reviewCount == 1 ? 'review' : 'reviews' }}</em>
</span>

@push('scripts')
<script src="{{ asset('js/star-rating.js') }}"></script>
@endpush

@push('styles')
<style>
.rating {
    display: flex;
    align-items: center;
    gap: 2px;
    margin-bottom: 0;
}

.rating .icon-star {
    font-style: normal;
    color: #ddd;
    transition: all 0.2s ease;
    font-size: {{ $iconSize }};
}

.rating .icon-star.voted {
    color: #ffc107;
}

.rating em {
    margin-left: 8px;
    color: #666;
    font-size: 0.9em;
    font-style: normal;
}

.rating-interactive .icon-star {
    cursor: pointer;
}

.rating-interactive .icon-star:hover {
    color: #ffc107;
    transform: scale(1.1);
}

.rating-interactive .icon-star:hover ~ .icon-star {
    color: #ddd;
}
</style>
@endpush
