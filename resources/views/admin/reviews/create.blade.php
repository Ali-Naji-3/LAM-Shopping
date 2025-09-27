@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                ➕ Create Review
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">Add a new customer review for a product</p>
        </div>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary" 
           style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
           onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
            <i class="bi bi-arrow-left me-2"></i>Back to Reviews
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Review Creation Form -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-star me-2" style="color: #3182ce !important;"></i>Review Details
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <form method="POST" action="{{ route('admin.reviews.store') }}">
                        @csrf
                        
                        <!-- User Selection -->
                        <div class="mb-4">
                            <label for="user_id" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Reviewer <span style="color: #e53e3e !important;">*</span>
                            </label>
                            <select class="form-control @error('user_id') is-invalid @enderror" 
                                    id="user_id" 
                                    name="user_id" 
                                    required
                                    style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                                <option value="">Select a user...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Product Selection -->
                        <div class="mb-4">
                            <label for="product_id" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Product <span style="color: #e53e3e !important;">*</span>
                            </label>
                            <select class="form-control @error('product_id') is-invalid @enderror" 
                                    id="product_id" 
                                    name="product_id" 
                                    required
                                    style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                    onchange="updateProductPreview(this)">
                                <option value="">Select a product...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                            data-name="{{ $product->name }}"
                                            data-price="{{ $product->regular_price }}"
                                            data-category="{{ $product->category->name ?? 'No Category' }}"
                                            {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} - ${{ number_format($product->regular_price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Rating Selection -->
                        <div class="mb-4">
                            <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Rating <span style="color: #e53e3e !important;">*</span>
                            </label>
                            <div class="rating-selection" style="display: flex; gap: 10px; align-items: center; margin-bottom: 10px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="rating-option" style="cursor: pointer; display: flex; align-items: center; gap: 8px; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 10px; transition: all 0.2s ease;">
                                        <input type="radio" name="rating" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }} style="display: none;">
                                        <div class="star-display" style="font-size: 18px; color: #fbbf24;">
                                            @for($j = 1; $j <= 5; $j++)
                                                <span class="star {{ $j <= $i ? 'filled' : 'empty' }}">{{ $j <= $i ? '★' : '☆' }}</span>
                                            @endfor
                                        </div>
                                        <span style="color: #1a202c; font-weight: 500; font-size: 14px;">{{ $i }}</span>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Review Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Review Title <small style="color: #718096 !important; font-weight: 400 !important;">(optional)</small>
                            </label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                   placeholder="Enter a title for the review (e.g., 'Great product!', 'Exceeded expectations')">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Review Comment -->
                        <div class="mb-4">
                            <label for="comment" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Review Comment <small style="color: #718096 !important; font-weight: 400 !important;">(optional)</small>
                            </label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" 
                                      id="comment" 
                                      name="comment" 
                                      rows="6"
                                      style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; line-height: 1.6 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important; resize: vertical !important;"
                                      placeholder="Write a detailed review about the product...">{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text" style="color: #718096 !important; font-size: 12px !important; margin-top: 6px !important;">Share your experience with the product. Be specific and helpful to other customers.</small>
                        </div>

                        <!-- Pros and Cons -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="pros" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                    Pros <small style="color: #718096 !important; font-weight: 400 !important;">(optional)</small>
                                </label>
                                <textarea class="form-control @error('pros') is-invalid @enderror" 
                                          id="pros" 
                                          name="pros" 
                                          rows="3"
                                          style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; line-height: 1.6 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important; resize: vertical !important;"
                                          placeholder="What did you like about this product?">{{ old('pros') }}</textarea>
                                @error('pros')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="cons" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                    Cons <small style="color: #718096 !important; font-weight: 400 !important;">(optional)</small>
                                </label>
                                <textarea class="form-control @error('cons') is-invalid @enderror" 
                                          id="cons" 
                                          name="cons" 
                                          rows="3"
                                          style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; line-height: 1.6 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important; resize: vertical !important;"
                                          placeholder="What could be improved?">{{ old('cons') }}</textarea>
                                @error('cons')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Recommendation and Purchase Verification -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-check" style="padding: 1rem; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-radius: 10px; border: 1px solid #e0f2fe;">
                                    <input class="form-check-input" type="checkbox" name="would_recommend" id="would_recommend" value="1" {{ old('would_recommend', true) ? 'checked' : '' }} style="margin-top: 4px;">
                                    <label class="form-check-label" for="would_recommend" style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-left: 8px;">
                                        <i class="bi bi-thumbs-up me-2" style="color: #10b981;"></i>I would recommend this product
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="purchase_verified" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                    Purchase Verification <small style="color: #718096 !important; font-weight: 400 !important;">(optional)</small>
                                </label>
                                <input type="text" 
                                       class="form-control @error('purchase_verified') is-invalid @enderror" 
                                       id="purchase_verified" 
                                       name="purchase_verified" 
                                       value="{{ old('purchase_verified') }}"
                                       style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                       placeholder="e.g., Order #12345, Verified Purchase">
                                @error('purchase_verified')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Approval Status -->
                        <div class="mb-4">
                            <div class="form-check" style="padding: 1rem; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-radius: 10px; border: 1px solid #e0f2fe;">
                                <input class="form-check-input" type="checkbox" name="is_approved" id="is_approved" value="1" {{ old('is_approved') ? 'checked' : '' }} style="margin-top: 4px;">
                                <label class="form-check-label" for="is_approved" style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-left: 8px;">
                                    <i class="bi bi-check-circle me-2" style="color: #10b981;"></i>Approve this review immediately
                                </label>
                                <div style="color: #4a5568 !important; font-size: 12px !important; margin-left: 28px; margin-top: 4px;">
                                    If unchecked, the review will be saved as "Pending" and require manual approval later.
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary" 
                               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 14px 24px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary" 
                                    style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: 2px solid #3182ce !important; color: #ffffff !important; padding: 14px 24px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; box-shadow: 0 2px 4px rgba(49, 130, 206, 0.2) !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.background='linear-gradient(135deg, #2c5aa0 0%, #2a4a8a 100%) !important'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
                                    onmouseout="this.style.background='linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(49, 130, 206, 0.2) !important';">
                                <i class="bi bi-check-circle me-2"></i>Create Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Selected Product Preview -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-box me-2" style="color: #3182ce !important;"></i>Product Preview
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div id="product-preview" class="text-center" style="padding: 2rem !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 10px !important; border: 1px solid #e2e8f0 !important;">
                        <i class="bi bi-box" style="color: #718096 !important; font-size: 3rem !important; margin-bottom: 1rem !important;"></i>
                        <h6 style="color: #4a5568 !important; font-weight: 500 !important;">Select a product to see preview</h6>
                    </div>
                </div>
            </div>

            <!-- Review Guidelines -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-lightbulb me-2" style="color: #3182ce !important;"></i>Review Guidelines
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div style="padding: 1.25rem !important; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important; border-radius: 10px !important; border-left: 4px solid #10b981 !important;">
                        <h6 style="color: #1a202c !important; font-weight: 600 !important; margin-bottom: 1rem !important;">✅ Good Reviews Include:</h6>
                        <ul style="margin-bottom: 0 !important; padding-left: 1.25rem !important;">
                            <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Specific product details</li>
                            <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Personal experience</li>
                            <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Pros and cons</li>
                            <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0 !important;">Helpful for other buyers</li>
                        </ul>
                    </div>
                    
                    <div class="mt-3" style="padding: 1.25rem !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 10px !important; border-left: 4px solid #f59e0b !important;">
                        <h6 style="color: #1a202c !important; font-weight: 600 !important; margin-bottom: 1rem !important;">⭐ Rating Scale:</h6>
                        <div style="font-size: 12px; line-height: 1.6;">
                            <div style="color: #2d3748; margin-bottom: 4px;"><strong>5 Stars:</strong> Excellent - Exceeded expectations</div>
                            <div style="color: #2d3748; margin-bottom: 4px;"><strong>4 Stars:</strong> Very Good - Met expectations</div>
                            <div style="color: #2d3748; margin-bottom: 4px;"><strong>3 Stars:</strong> Good - Average experience</div>
                            <div style="color: #2d3748; margin-bottom: 4px;"><strong>2 Stars:</strong> Fair - Below expectations</div>
                            <div style="color: #2d3748;"><strong>1 Star:</strong> Poor - Significant issues</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Rating selection functionality
    const ratingOptions = document.querySelectorAll('.rating-option');
    
    ratingOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove active class from all options
            ratingOptions.forEach(opt => {
                opt.style.borderColor = '#e2e8f0';
                opt.style.backgroundColor = '#ffffff';
            });
            
            // Add active class to selected option
            this.style.borderColor = '#3182ce';
            this.style.backgroundColor = '#f0f9ff';
            
            // Check the radio button
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
        });
        
        // Check if this option should be pre-selected
        const radio = option.querySelector('input[type="radio"]');
        if (radio.checked) {
            option.style.borderColor = '#3182ce';
            option.style.backgroundColor = '#f0f9ff';
        }
    });
});

// Update product preview
function updateProductPreview(select) {
    const selectedOption = select.options[select.selectedIndex];
    const preview = document.getElementById('product-preview');
    
    if (selectedOption.value) {
        const name = selectedOption.dataset.name;
        const price = selectedOption.dataset.price;
        const category = selectedOption.dataset.category;
        
        preview.innerHTML = `
            <div class="product-icon" style="background: #3182ce !important; width: 60px !important; height: 60px !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important; margin: 0 auto 12px auto !important;">
                <i class="bi bi-box" style="color: #ffffff !important; font-size: 24px !important;"></i>
            </div>
            <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 8px !important;">${name}</h6>
            <div style="color: #10b981 !important; font-weight: 700 !important; font-size: 18px !important; margin-bottom: 4px !important;">$${parseFloat(price).toFixed(2)}</div>
            <div style="color: #4a5568 !important; font-size: 12px !important; font-weight: 500 !important;">${category}</div>
        `;
    } else {
        preview.innerHTML = `
            <i class="bi bi-box" style="color: #718096 !important; font-size: 3rem !important; margin-bottom: 1rem !important;"></i>
            <h6 style="color: #4a5568 !important; font-weight: 500 !important;">Select a product to see preview</h6>
        `;
    }
}
</script>
@endpush

@push('styles')
<style>
    /* CLEAN REVIEWS CREATE PAGE - Professional Styling */
    .form-control:hover {
        border-color: #cbd5e0 !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    }
    
    .form-control:focus {
        background: #ffffff !important;
        border: 2px solid #3182ce !important;
        color: #1a202c !important;
        box-shadow: 0 0 0 4px rgba(49, 130, 206, 0.15), 0 2px 8px rgba(49, 130, 206, 0.1) !important;
        outline: none !important;
        transform: translateY(-1px) !important;
    }
    
    .form-control::placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    
    .rating-option {
        transition: all 0.2s ease !important;
    }
    
    .rating-option:hover {
        border-color: #3182ce !important;
        background-color: #f0f9ff !important;
        transform: translateY(-1px) !important;
    }
    
    .product-icon {
        transition: all 0.2s ease !important;
    }
    
    .product-icon:hover {
        transform: scale(1.1) !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .rating-selection {
            flex-direction: column !important;
            gap: 8px !important;
        }
        
        .rating-option {
            width: 100% !important;
            justify-content: center !important;
        }
    }
</style>
@endpush
@endsection
