/**
 * Dynamic Star Rating System
 * Activates star ratings with real data from the database
 */

class StarRating {
    constructor(container, options = {}) {
        this.container = container;
        this.options = {
            rating: 0,
            maxRating: 5,
            interactive: false,
            showCount: false,
            reviewCount: 0,
            size: 'normal',
            onRatingChange: null,
            ...options
        };
        
        this.init();
    }
    
    init() {
        this.createHTML();
        this.bindEvents();
        this.updateDisplay();
    }
    
    createHTML() {
        const sizeClasses = {
            'small': 'text-sm',
            'normal': 'text-base', 
            'large': 'text-lg'
        };
        
        const iconSizes = {
            'small': '14px',
            'normal': '18px',
            'large': '22px'
        };
        
        const currentSize = sizeClasses[this.options.size] || sizeClasses['normal'];
        const iconSize = iconSizes[this.options.size] || iconSizes['normal'];
        
        this.container.innerHTML = `
            <div class="star-rating-container ${currentSize}">
                <span class="rating ${this.options.interactive ? 'rating-interactive' : ''}">
                    ${this.generateStars(iconSize)}
                    ${this.options.showCount ? `<em>${this.options.reviewCount} ${this.options.reviewCount === 1 ? 'review' : 'reviews'}</em>` : ''}
                </span>
            </div>
        `;
    }
    
    generateStars(iconSize) {
        let stars = '';
        for (let i = 1; i <= this.options.maxRating; i++) {
            const isVoted = i <= Math.floor(this.options.rating);
            const starClass = isVoted ? 'icon-star voted' : 'icon-star';
            
            if (this.options.interactive) {
                stars += `
                    <input type="radio" 
                           class="rating-input" 
                           id="rating_${i}_star" 
                           name="rating" 
                           value="${i}"
                           ${this.options.rating == i ? 'checked' : ''}
                           style="display: none;">
                    <label for="rating_${i}_star" 
                           class="rating-star ${isVoted ? 'voted' : ''}"
                           style="font-size: ${iconSize}; cursor: pointer;">
                        <i class="icon-star"></i>
                    </label>
                `;
            } else {
                stars += `<i class="${starClass}" style="font-size: ${iconSize}; color: ${isVoted ? '#ffc107' : '#ddd'};"></i>`;
            }
        }
        return stars;
    }
    
    bindEvents() {
        if (!this.options.interactive) return;
        
        const stars = this.container.querySelectorAll('.rating-star');
        const inputs = this.container.querySelectorAll('.rating-input');
        
        stars.forEach((star, index) => {
            star.addEventListener('mouseenter', () => this.highlightStars(index));
            star.addEventListener('mouseleave', () => this.resetStars());
            star.addEventListener('click', () => this.selectRating(index + 1));
        });
    }
    
    highlightStars(upToIndex) {
        const stars = this.container.querySelectorAll('.rating-star');
        stars.forEach((star, index) => {
            star.style.color = index <= upToIndex ? '#ffc107' : '#ddd';
        });
    }
    
    resetStars() {
        const stars = this.container.querySelectorAll('.rating-star');
        const checkedInput = this.container.querySelector('input[type="radio"]:checked');
        
        if (checkedInput) {
            const rating = parseInt(checkedInput.value);
            stars.forEach((star, index) => {
                star.style.color = index < rating ? '#ffc107' : '#ddd';
            });
        } else {
            stars.forEach(star => star.style.color = '#ddd');
        }
    }
    
    selectRating(rating) {
        const input = this.container.querySelector(`input[value="${rating}"]`);
        if (input) {
            input.checked = true;
            this.options.rating = rating;
            this.updateDisplay();
            
            if (this.options.onRatingChange) {
                this.options.onRatingChange(rating);
            }
        }
    }
    
    updateDisplay() {
        const stars = this.container.querySelectorAll('.rating-star');
        const checkedInput = this.container.querySelector('input[type="radio"]:checked');
        
        if (checkedInput) {
            const rating = parseInt(checkedInput.value);
            stars.forEach((star, index) => {
                star.style.color = index < rating ? '#ffc107' : '#ddd';
            });
        }
    }
    
    setRating(rating) {
        this.options.rating = rating;
        this.updateDisplay();
    }
    
    getRating() {
        return this.options.rating;
    }
}

// Auto-initialize star ratings on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all static star ratings
    const ratingContainers = document.querySelectorAll('.rating:not(.rating-interactive)');
    ratingContainers.forEach(container => {
        const rating = parseFloat(container.dataset.rating) || 0;
        const reviewCount = parseInt(container.dataset.reviewCount) || 0;
        
        new StarRating(container, {
            rating: rating,
            reviewCount: reviewCount,
            showCount: true,
            interactive: false
        });
    });
    
    // Initialize interactive star ratings
    const interactiveContainers = document.querySelectorAll('.rating-interactive');
    interactiveContainers.forEach(container => {
        const rating = parseFloat(container.dataset.rating) || 0;
        const reviewCount = parseInt(container.dataset.reviewCount) || 0;
        
        new StarRating(container, {
            rating: rating,
            reviewCount: reviewCount,
            showCount: true,
            interactive: true,
            onRatingChange: function(newRating) {
                console.log('Rating changed to:', newRating);
                // You can add AJAX call here to save the rating
            }
        });
    });
});

// CSS for star rating styling
const starRatingCSS = `
<style>
.rating {
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

.icon-star {
    font-style: normal;
    color: #ddd;
    transition: all 0.2s ease;
}

.icon-star.voted {
    color: #ffc107;
}

.rating em {
    margin-left: 8px;
    color: #666;
    font-size: 0.9em;
}
</style>
`;

// Inject CSS
document.head.insertAdjacentHTML('beforeend', starRatingCSS);

// Export for use in other scripts
window.StarRating = StarRating;
