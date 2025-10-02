@extends('frontend.layouts.layout')
@section('content')
    <main>


        <div class="container margin_60_35">

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="write_review">
                        @if ($product)
                            <h1>Write a review for {{ $product->name }}</h1>
                        @else
                            <h1>Write a review</h1>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong><i class="ti-alert"></i> Error:</strong> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong><i class="ti-alert"></i> Please fix the following errors:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('frontend.review.store') }}" method="POST" id="reviewForm">
                            @csrf

                            @if ($product)
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                            @else
                                <div class="form-group">
                                    <label for="product_id">Select Product <span class="text-danger">*</span></label>
                                    <select name="product_id" id="product_id" class="form-control" required>
                                        <option value="">Choose a product...</option>
                                        @foreach ($products as $prod)
                                            <option value="{{ $prod->id }}">{{ $prod->name }} -
                                                {{ $prod->brand->name ?? 'No Brand' }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            <div class="rating_submit">
                                <div class="form-group">
                                    <label class="d-block">Overall rating <span class="text-danger">*</span></label>
                                    <span class="rating mb-0">
                                        <input type="radio" class="rating-input" id="5_star" name="rating" value="5">
                                        <label for="5_star" class="rating-star"></label>
                                        <input type="radio" class="rating-input" id="4_star" name="rating" value="4">
                                        <label for="4_star" class="rating-star"></label>
                                        <input type="radio" class="rating-input" id="3_star" name="rating" value="3">
                                        <label for="3_star" class="rating-star"></label>
                                        <input type="radio" class="rating-input" id="2_star" name="rating" value="2">
                                        <label for="2_star" class="rating-star"></label>
                                        <input type="radio" class="rating-input" id="1_star" name="rating" value="1">
                                        <label for="1_star" class="rating-star"></label>
                                    </span>
                                    <div id="rating-error" class="text-danger small mt-2" style="display: none;">
                                        <i class="ti-alert"></i> Please select a rating
                                    </div>
                                    @error('rating')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- /rating_submit -->

                            @guest
                                <div class="form-group">
                                    <label for="name">Your Name <span class="text-danger">*</span></label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name"
                                        placeholder="Enter your full name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback d-block">
                                            <i class="ti-alert"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Your Email <span class="text-danger">*</span></label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email"
                                        placeholder="Enter your email address" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback d-block">
                                            <i class="ti-alert"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endguest

                            <div class="form-group">
                                <label for="title">Title of your review <span class="badge bg-secondary badge-sm">Optional</span></label>
                                <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title"
                                    placeholder="If you could say it in one sentence, what would you say?"
                                    value="{{ old('title') }}">
                                @error('title')
                                    <div class="invalid-feedback d-block">
                                        <i class="ti-alert"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="comment">Your review <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('comment') is-invalid @enderror" name="comment" id="comment" style="height: 180px;"
                                    placeholder="Write your review to help others learn about this product" required>{{ old('comment') }}</textarea>
                                @error('comment')
                                    <div class="invalid-feedback d-block">
                                        <i class="ti-alert"></i> {{ $message }}
                                    </div>
                                @enderror
                                <small class="text-muted">
                                    <span id="comment-count">0</span>/2000 characters
                                </small>
                            </div>

                            <div class="form-group">
                                <div class="checkboxes float-left add_bottom_15 add_top_15">
                                    <label class="container_check">I agree to the <a href="#" target="_blank">Terms
                                            and Conditions</a> and <a href="#" target="_blank">Privacy Policy</a>
                                        <input type="checkbox" required>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn_1" id="submit-review-btn">Submit review</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reviewForm');
    const ratingInputs = document.querySelectorAll('input[name="rating"]');
    const ratingError = document.getElementById('rating-error');
    const submitBtn = document.getElementById('submit-review-btn');

    // Remove required attribute from all rating inputs (to prevent browser validation error)
    ratingInputs.forEach(input => {
        input.removeAttribute('required');
    });

    // Add visual feedback when rating is selected
    ratingInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (ratingError) {
                ratingError.style.display = 'none';
            }
            // Add a subtle animation
            this.nextElementSibling.style.transform = 'scale(1.2)';
            setTimeout(() => {
                this.nextElementSibling.style.transform = 'scale(1)';
            }, 200);
        });
    });

    // Character counter for comment
    const commentTextarea = document.getElementById('comment');
    const commentCount = document.getElementById('comment-count');
    
    if (commentTextarea && commentCount) {
        commentTextarea.addEventListener('input', function() {
            const length = this.value.length;
            commentCount.textContent = length;
            
            if (length > 1800) {
                commentCount.style.color = '#f59e0b'; // Warning color
            } else {
                commentCount.style.color = '#4a5568';
            }
        });
        
        // Initial count
        commentCount.textContent = commentTextarea.value.length;
    }

    // Custom validation on form submit
    form.addEventListener('submit', function(e) {
        let isValid = true;
        let errors = [];
        
        // Check rating
        const selectedRating = document.querySelector('input[name="rating"]:checked');
        if (!selectedRating) {
            isValid = false;
            errors.push('⭐ Rating is required');
            
            if (ratingError) {
                ratingError.style.display = 'block';
            }
            
            const ratingContainer = document.querySelector('.rating');
            ratingContainer.style.animation = 'shake 0.5s';
            setTimeout(() => {
                ratingContainer.style.animation = '';
            }, 500);
        }
        
        // Check comment
        if (commentTextarea && commentTextarea.value.trim().length === 0) {
            isValid = false;
            errors.push('📝 Review comment is required');
            commentTextarea.classList.add('is-invalid');
            commentTextarea.style.borderColor = '#dc3545';
        } else if (commentTextarea) {
            commentTextarea.classList.remove('is-invalid');
            commentTextarea.style.borderColor = '';
        }
        
        // Check name (for guests)
        const nameInput = document.getElementById('name');
        if (nameInput && nameInput.value.trim().length === 0) {
            isValid = false;
            errors.push('👤 Name is required');
            nameInput.classList.add('is-invalid');
            nameInput.style.borderColor = '#dc3545';
        }
        
        // Check email (for guests)
        const emailInput = document.getElementById('email');
        if (emailInput && emailInput.value.trim().length === 0) {
            isValid = false;
            errors.push('📧 Email is required');
            emailInput.classList.add('is-invalid');
            emailInput.style.borderColor = '#dc3545';
        }
        
        // Check product selection
        const productSelect = document.getElementById('product_id');
        if (productSelect && !productSelect.value) {
            isValid = false;
            errors.push('📦 Product selection is required');
            productSelect.classList.add('is-invalid');
            productSelect.style.borderColor = '#dc3545';
        }
        
        if (!isValid) {
            e.preventDefault();
            
            // Scroll to first error
            document.querySelector('.rating_submit').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
            
            // Show comprehensive error alert
            alert('❌ Please fix the following errors:\n\n' + errors.join('\n'));
            
            return false;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="ti-reload"></i> Submitting...';
        submitBtn.style.opacity = '0.6';
    });
    
    // Remove error styling on input
    const allInputs = form.querySelectorAll('input, textarea, select');
    allInputs.forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            this.style.borderColor = '';
        });
    });
});

// Add shake animation
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    
    .rating-star {
        transition: transform 0.2s ease;
    }
    
    .rating-input:checked + .rating-star {
        transform: scale(1.1);
    }
`;
document.head.appendChild(style);
</script>
@endpush
