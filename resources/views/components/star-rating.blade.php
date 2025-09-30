@props([
    'rating' => 0,
    'maxRating' => 5,
    'showCount' => false,
    'reviewCount' => 0,
    'size' => 'normal', // 'small', 'normal', 'large'
    'interactive' => false,
    'name' => 'rating',
    'class' => ''
])

@php
    $sizeClasses = [
        'small' => 'text-sm',
        'normal' => 'text-base',
        'large' => 'text-lg'
    ];
    
    $iconSize = [
        'small' => '12px',
        'normal' => '16px',
        'large' => '20px'
    ];
    
    $currentSize = $sizeClasses[$size] ?? $sizeClasses['normal'];
    $currentIconSize = $iconSize[$size] ?? $iconSize['normal'];
@endphp

<div class="rating-component {{ $currentSize }} {{ $class }}" 
     @if($interactive) data-interactive="true" @endif>
    <span class="rating {{ $interactive ? 'rating-interactive' : '' }}">
        @for($i = 1; $i <= $maxRating; $i++)
            @if($interactive)
                <input type="radio" 
                       class="rating-input" 
                       id="{{ $name }}_{{ $i }}_star" 
                       name="{{ $name }}" 
                       value="{{ $i }}"
                       {{ $rating == $i ? 'checked' : '' }}
                       style="display: none;">
                <label for="{{ $name }}_{{ $i }}_star" 
                       class="rating-star {{ $i <= $rating ? 'voted' : '' }}"
                       style="font-size: {{ $currentIconSize }}; cursor: pointer;">
                    <i class="icon-star"></i>
                </label>
            @else
                <i class="icon-star {{ $i <= $rating ? 'voted' : '' }}" 
                   style="font-size: {{ $currentIconSize }};"></i>
            @endif
        @endfor
        
        @if($showCount)
            <em>{{ $reviewCount }} {{ $reviewCount == 1 ? 'review' : 'reviews' }}</em>
        @endif
    </span>
</div>

@if($interactive)
<style>
.rating-interactive {
    display: flex;
    align-items: center;
    gap: 2px;
}

.rating-interactive .rating-star {
    transition: all 0.2s ease;
    color: #ddd;
}

.rating-interactive .rating-star:hover,
.rating-interactive .rating-star.voted {
    color: #ffc107;
    transform: scale(1.1);
}

.rating-interactive .rating-star:hover ~ .rating-star {
    color: #ddd;
}

.rating-interactive input[type="radio"]:checked + .rating-star {
    color: #ffc107;
}

.rating-interactive input[type="radio"]:checked + .rating-star ~ .rating-star {
    color: #ddd;
}
</style>
@endif
