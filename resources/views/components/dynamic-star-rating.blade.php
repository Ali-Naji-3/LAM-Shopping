@props([
    'product' => null,
    'review' => null,
    'rating' => null,
    'reviewCount' => null,
    'size' => 'normal',
    'interactive' => false,
    'showCount' => true,
    'showAverage' => false,
    'class' => ''
])

@php
    // Determine rating source
    if ($product) {
        $averageRating = $product->reviews()->where('is_approved', true)->avg('rating') ?? 0;
        $totalReviews = $product->reviews()->where('is_approved', true)->count();
    } elseif ($review) {
        $averageRating = $review->rating;
        $totalReviews = 1;
    } elseif ($rating !== null) {
        $averageRating = $rating;
        $totalReviews = $reviewCount ?? 0;
    } else {
        $averageRating = 0;
        $totalReviews = 0;
    }
    
    $sizeClasses = [
        'small' => 'text-xs',
        'normal' => 'text-sm',
        'large' => 'text-base'
    ];
    
    $iconSize = [
        'small' => '14px',
        'normal' => '18px',
        'large' => '22px'
    ];
    
    $currentSize = $sizeClasses[$size] ?? $sizeClasses['normal'];
    $currentIconSize = $iconSize[$size] ?? $iconSize['normal'];
@endphp

<div class="dynamic-star-rating {{ $currentSize }} {{ $class }}" 
     data-rating="{{ $averageRating }}"
     data-review-count="{{ $totalReviews }}"
     @if($interactive) data-interactive="true" @endif>
    
    <span class="rating {{ $interactive ? 'rating-interactive' : '' }}">
        @for($i = 1; $i <= 5; $i++)
            @if($interactive)
                <input type="radio" 
                       class="rating-input" 
                       id="rating_{{ $i }}_star" 
                       name="rating" 
                       value="{{ $i }}"
                       {{ $averageRating == $i ? 'checked' : '' }}
                       style="display: none;">
                <label for="rating_{{ $i }}_star" 
                       class="rating-star {{ $i <= floor($averageRating) ? 'voted' : '' }}"
                       style="font-size: {{ $currentIconSize }}; cursor: pointer; transition: all 0.2s ease;">
                    <i class="icon-star"></i>
                </label>
            @else
                <i class="icon-star {{ $i <= floor($averageRating) ? 'voted' : '' }}" 
                   style="font-size: {{ $currentIconSize }}; color: {{ $i <= floor($averageRating) ? '#ffc107' : '#ddd' }};"></i>
            @endif
        @endfor
        
        @if($showCount && $totalReviews > 0)
            <em style="margin-left: 8px; color: #666; font-size: 0.9em;">
                {{ $totalReviews }} {{ $totalReviews == 1 ? 'review' : 'reviews' }}
            </em>
        @endif
        
        @if($showAverage && $totalReviews > 0)
            <em style="margin-left: 8px; color: #666; font-size: 0.9em;">
                ({{ number_format($averageRating, 1) }}/5.0)
            </em>
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
    cursor: pointer;
}

.rating-interactive .rating-star:hover {
    color: #ffc107;
    transform: scale(1.1);
}

.rating-interactive .rating-star.voted {
    color: #ffc107;
}

.rating-interactive input[type="radio"]:checked + .rating-star {
    color: #ffc107;
}

.rating-interactive input[type="radio"]:checked + .rating-star ~ .rating-star {
    color: #ddd;
}

.rating-interactive .rating-star:hover ~ .rating-star {
    color: #ddd;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ratingComponents = document.querySelectorAll('.dynamic-star-rating[data-interactive="true"]');
    
    ratingComponents.forEach(component => {
        const stars = component.querySelectorAll('.rating-star');
        const inputs = component.querySelectorAll('.rating-input');
        
        stars.forEach((star, index) => {
            star.addEventListener('mouseenter', function() {
                // Highlight stars up to this one
                for (let i = 0; i <= index; i++) {
                    stars[i].style.color = '#ffc107';
                }
                // Dim stars after this one
                for (let i = index + 1; i < stars.length; i++) {
                    stars[i].style.color = '#ddd';
                }
            });
            
            star.addEventListener('mouseleave', function() {
                // Reset to current rating
                const checkedInput = component.querySelector('input[type="radio"]:checked');
                if (checkedInput) {
                    const rating = parseInt(checkedInput.value);
                    for (let i = 0; i < stars.length; i++) {
                        stars[i].style.color = i < rating ? '#ffc107' : '#ddd';
                    }
                } else {
                    // Reset to no rating
                    stars.forEach(s => s.style.color = '#ddd');
                }
            });
            
            star.addEventListener('click', function() {
                const input = inputs[index];
                input.checked = true;
                
                // Update visual state
                for (let i = 0; i < stars.length; i++) {
                    stars[i].style.color = i <= index ? '#ffc107' : '#ddd';
                }
                
                // Trigger change event
                input.dispatchEvent(new Event('change'));
            });
        });
    });
});
</script>
@endif
