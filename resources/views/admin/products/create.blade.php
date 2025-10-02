@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Create New Product</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- ============================================ -->
                        <!-- SECTION 1: BASIC PRODUCT INFORMATION -->
                        <!-- ============================================ -->
                        <div class="section-divider mb-5">
                            <h4 class="section-title">
                                <span class="badge bg-primary rounded-pill me-2">1</span>
                                <i class="fas fa-info-circle me-2"></i>Basic Product Information
                            </h4>
                            <p class="text-muted small mb-4">Enter the essential product details and categorization</p>
                            
                            {{-- Basic Information Fields (Shared Component) --}}
                            @include('admin.products.partials._basic_fields', ['product' => null, 'categories' => $categories, 'brands' => $brands])

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="form-label fw-bold">
                                    <i class="fas fa-align-left me-1 text-primary"></i>Product Description
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" placeholder="Describe your product in detail...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-lightbulb text-warning"></i> Include key features, materials, and benefits
                                </small>
                            </div>
                        </div>

                        <!-- ============================================ -->
                        <!-- SECTION 2: PRICING & INVENTORY -->
                        <!-- ============================================ -->
                        <div class="section-divider mb-5">
                            <h4 class="section-title">
                                <span class="badge bg-success rounded-pill me-2">2</span>
                                <i class="fas fa-dollar-sign me-2"></i>Pricing & Inventory
                            </h4>
                            <p class="text-muted small mb-4">Set product pricing and stock information</p>
                            
                            {{-- Price and Stock Fields (Shared Component) --}}
                            @include('admin.products.partials._price_fields', ['product' => null])
                        </div>

                        <!-- ============================================ -->
                        <!-- SECTION 3: PRODUCT IMAGES -->
                        <!-- ============================================ -->
                        <div class="section-divider mb-5">
                            <h4 class="section-title">
                                <span class="badge bg-info rounded-pill me-2">3</span>
                                <i class="fas fa-images me-2"></i>Product Images
                            </h4>
                            <p class="text-muted small mb-4">Upload high-quality product images</p>

                            <!-- Primary Image -->
                            <div class="mb-4">
                                <label for="image" class="form-label fw-bold">
                                    <i class="fas fa-image me-1 text-danger"></i>Primary Image <span class="text-danger">*</span>
                                </label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" required>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle text-info"></i> This will be the main product image (JPG, PNG, WebP - max 5MB)
                                </small>
                            </div>

                            <!-- Simple Gallery Images -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-th me-1 text-primary"></i>Gallery Images <span class="badge bg-secondary badge-sm">Optional</span>
                                </label>
                                <input type="file" id="gallery-images" name="gallery_images[]" accept="image/*" multiple class="form-control @error('gallery_images') is-invalid @enderror">
                                <small class="form-text text-muted">
                                    <i class="fas fa-images text-info"></i> Select multiple images for the gallery (JPG, PNG, WebP - max 5MB each)
                                </small>
                                @error('gallery_images')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Simple Gallery Preview -->
                            <div id="gallery-preview" style="display: none; border: 1px solid #dee2e6; padding: 1rem; border-radius: 8px; background: #f8f9fa; margin-top: 1rem;">
                                <h6><i class="fas fa-eye me-2"></i>Gallery Preview (<span id="gallery-count">0</span> images)</h6>
                                <div id="gallery-grid" class="row g-2"></div>
                            </div>
                        </div>

                        <!-- ============================================ -->
                        <!-- SECTION 4: PRODUCT VARIANTS -->
                        <!-- ============================================ -->
                        <div class="section-divider mb-5">
                            <h4 class="section-title">
                                <span class="badge bg-warning rounded-pill me-2">4</span>
                                <i class="fas fa-palette me-2"></i>Product Variants
                            </h4>
                            <p class="text-muted small mb-4">Define colors and sizes available for this product</p>

                        <!-- Color Management Section -->
                        <div class="mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-0">🎨 Color Management</h5>
                                        <small class="text-muted">Add colors for this product. These will appear as color dots on the frontend.</small>
                                    </div>
                                    <a href="{{ route('admin.attributes.values', ['attribute' => 1]) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                        <i class="fas fa-cog me-1"></i> Manage All Colors
                                    </a>
                                </div>
                                <div class="card-body">
                                    <!-- Popular Colors Quick Select -->
                                    <div id="popular-colors-section" class="mb-3" style="display:none;">
                                        <div class="alert alert-light border">
                                            <strong><i class="fas fa-fire text-danger me-1"></i>Popular Colors:</strong>
                                            <div id="popular-colors-list" class="d-flex flex-wrap gap-2 mt-2">
                                                <!-- Populated dynamically -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Auto-Sync Notification -->
                                    <div id="color-sync-notification" class="alert alert-success border-left" style="display:none; border-left: 4px solid #28a745 !important;">
                                        <i class="fas fa-sync-alt me-1"></i>
                                        <strong>Auto-Sync Active:</strong> 
                                        <span id="color-sync-message">New colors will be added to your global color library automatically!</span>
                                    </div>

                                    <!-- Color Input Section -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="color_name" class="form-label">Color Name</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="color_name" 
                                                   list="existing-colors" 
                                                   placeholder="e.g., Navy Blue, Forest Green"
                                                   autocomplete="off">
                                            <datalist id="existing-colors">
                                                <!-- Populated dynamically from database -->
                                            </datalist>
                                            <small class="text-muted">
                                                <i class="fas fa-sync text-success"></i> <strong>Auto-syncs to global library</strong> • Start typing to see existing colors
                                            </small>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="color_hex" class="form-label">Color Code</label>
                                            <input type="color" class="form-control" id="color_hex" value="#000000">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="color_stock" class="form-label">Stock <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="color_stock" placeholder="Quantity" min="1" required>
                                            <small class="text-muted">Minimum 1 item required</small>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-primary w-100" onclick="addColor()">
                                                <i class="fas fa-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Color Preview Section -->
                                    <div id="colors-preview" class="mb-3">
                                        <h6>Selected Colors:</h6>
                                        <div id="colors-list" class="d-flex flex-wrap gap-2">
                                            <span class="text-muted">No colors added yet</span>
                                        </div>
                                    </div>

                                    <!-- Hidden inputs for form submission -->
                                    <div id="color-inputs"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Size Management Section -->
                        <div class="mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-0">📏 Size Management</h5>
                                        <small class="text-muted">Add sizes for this product. These will appear as size buttons on the frontend.</small>
                                    </div>
                                    <a href="{{ route('admin.attributes.values', ['attribute' => 2]) }}" class="btn btn-sm btn-outline-success" target="_blank">
                                        <i class="fas fa-cog me-1"></i> Manage All Sizes
                                    </a>
                                </div>
                                <div class="card-body">
                                    <!-- Popular Sizes Quick Select -->
                                    <div id="popular-sizes-section" class="mb-3" style="display:none;">
                                        <div class="alert alert-light border">
                                            <strong><i class="fas fa-fire text-warning me-1"></i>Popular Sizes:</strong>
                                            <div id="popular-sizes-list" class="d-flex flex-wrap gap-2 mt-2">
                                                <!-- Populated dynamically -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Auto-Sync Notification -->
                                    <div id="size-sync-notification" class="alert alert-success border-left mb-3" style="display:none; border-left: 4px solid #28a745 !important;">
                                        <i class="fas fa-sync-alt me-1"></i>
                                        <strong>Auto-Sync Active:</strong> 
                                        <span id="size-sync-message">New sizes will be added to your global size library automatically!</span>
                                    </div>

                                    <!-- Size Input Section -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="size_name" class="form-label">Size Name</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="size_name" 
                                                   list="existing-sizes"
                                                   placeholder="e.g., Small, Medium, Large, XL"
                                                   autocomplete="off">
                                            <datalist id="existing-sizes">
                                                <!-- Populated dynamically from database -->
                                            </datalist>
                                            <small class="text-muted">
                                                <i class="fas fa-sync text-success"></i> <strong>Auto-syncs to global library</strong> • Start typing to see existing sizes
                                            </small>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="size_stock" class="form-label">Stock <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="size_stock" placeholder="Quantity" min="1" required>
                                            <small class="text-muted">Minimum 1 item required</small>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="size_guide" class="form-label">Size Guide</label>
                                            <input type="text" class="form-control" id="size_guide" placeholder="e.g., Chest: 36-38 inches">
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-primary w-100" onclick="addSize()">
                                                <i class="fas fa-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Size Preview Section -->
                                    <div id="sizes-preview" class="mb-3">
                                        <h6>Selected Sizes:</h6>
                                        <div id="sizes-list" class="d-flex flex-wrap gap-2">
                                            <span class="text-muted">No sizes added yet</span>
                                        </div>
                                    </div>

                                    <!-- Hidden inputs for form submission -->
                                    <div id="size-inputs"></div>
                                </div>
                            </div>
                        </div>
                        </div>

                        <!-- ============================================ -->
                        <!-- SECTION 5: MARKETING & DISPLAY OPTIONS -->
                        <!-- ============================================ -->
                        <div class="section-divider mb-5">
                            <h4 class="section-title">
                                <span class="badge bg-purple rounded-pill me-2">5</span>
                                <i class="fas fa-bullhorn me-2"></i>Marketing & Display Options
                            </h4>
                            <p class="text-muted small mb-4">Control product visibility and promotional features</p>

                            <!-- Status -->
                            <div class="mb-4">
                                <div class="card border-left-primary shadow-sm" style="border-left: 4px solid #4e73df !important;">
                                    <div class="card-body">
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="status" value="0">
                                            <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status') ? 'checked' : '' }} style="width: 3rem; height: 1.5rem;">
                                            <label class="form-check-label ms-2" for="status">
                                                <strong><i class="fas fa-toggle-on me-1 text-success"></i>Product Status - Active</strong>
                                                <div><small class="text-muted">Enable this to make the product visible on the storefront</small></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <!-- New Arrival Controls -->
                        <div class="mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <h5 class="mb-0 text-white">
                                        <i class="fas fa-star-half-alt me-2"></i>New Arrival Settings
                                    </h5>
                                    <small class="text-white-50">Control how this product appears in new arrivals section</small>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="p-3 rounded" style="background-color: #f8f9fa; border-left: 4px solid #667eea;">
                                                <div class="form-check">
                                                    <input type="hidden" name="is_new_arrival" value="0">
                                                    <input class="form-check-input" type="checkbox" id="is_new_arrival" name="is_new_arrival" value="1" {{ old('is_new_arrival') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_new_arrival">
                                                        <strong class="text-dark"><i class="fas fa-tag me-1"></i>Mark as New Arrival</strong>
                                                    </label>
                                                    <div>
                                                        <small class="text-muted">Manually mark this product as a new arrival</small>
                                                    </div>
                                                </div>
                                                <div id="new-arrival-info" class="alert alert-warning mt-2 mb-0" style="display:none;">
                                                    <i class="fas fa-info-circle"></i>
                                                    <strong>Note:</strong> This will automatically remove the oldest new arrival product to make room for this one (max 8 products).
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 rounded" style="background-color: #f8f9fa; border-left: 4px solid #764ba2;">
                                                <div class="form-check">
                                                    <input type="hidden" name="featured_new_arrival" value="0">
                                                    <input class="form-check-input" type="checkbox" id="featured_new_arrival" name="featured_new_arrival" value="1" {{ old('featured_new_arrival') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="featured_new_arrival">
                                                        <strong class="text-dark"><i class="fas fa-certificate me-1"></i>Featured New Arrival</strong>
                                                    </label>
                                                    <div>
                                                        <small class="text-muted">Give this product special highlighting</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="new_arrival_until" class="form-label fw-bold">
                                                <i class="fas fa-calendar-times me-1 text-primary"></i>New Arrival Until <span class="badge bg-secondary badge-sm">Optional</span>
                                            </label>
                                            <input type="datetime-local" class="form-control @error('new_arrival_until') is-invalid @enderror" id="new_arrival_until" name="new_arrival_until" value="{{ old('new_arrival_until') }}">
                                            @error('new_arrival_until')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                <i class="fas fa-lightbulb text-warning"></i> Leave empty for permanent new arrival status
                                            </small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="new_arrival_priority" class="form-label fw-bold">
                                                <i class="fas fa-sort-amount-up me-1 text-success"></i>Priority Order
                                            </label>
                                            <select class="form-control @error('new_arrival_priority') is-invalid @enderror" id="new_arrival_priority" name="new_arrival_priority">
                                                <option value="0" {{ old('new_arrival_priority', 0) == 0 ? 'selected' : '' }}>⚪ Normal (0)</option>
                                                <option value="1" {{ old('new_arrival_priority') == 1 ? 'selected' : '' }}>🟡 Low (1)</option>
                                                <option value="3" {{ old('new_arrival_priority') == 3 ? 'selected' : '' }}>🟠 Medium (3)</option>
                                                <option value="5" {{ old('new_arrival_priority') == 5 ? 'selected' : '' }}>🔴 High (5)</option>
                                                <option value="10" {{ old('new_arrival_priority') == 10 ? 'selected' : '' }}>⭐ Highest (10)</option>
                                            </select>
                                            @error('new_arrival_priority')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                <i class="fas fa-arrow-up text-success"></i> Higher priority products appear first
                                            </small>
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-info mb-0" style="border-left: 4px solid #17a2b8;">
                                        <i class="fas fa-info-circle me-1"></i>
                                        <strong>Tip:</strong> Products created within the last 30 days automatically qualify as new arrivals unless manually disabled.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Countdown Timer Settings -->
                        <div class="mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                    <h5 class="mb-0 text-white">
                                        <i class="fas fa-clock me-2"></i>Countdown Timer Settings
                                    </h5>
                                    <small class="text-white-50">Add urgency with a countdown timer on product page</small>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="p-3 rounded" style="background-color: #fff5f5; border-left: 4px solid #f5576c;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="enable_countdown" name="enable_countdown" value="1" {{ old('enable_countdown') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="enable_countdown">
                                                        <strong class="text-dark"><i class="fas fa-stopwatch me-1"></i>Enable Countdown Timer</strong>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="countdown_date" class="form-label fw-bold">
                                                <i class="fas fa-calendar-check me-1 text-danger"></i>Countdown End Date
                                            </label>
                                            <input type="datetime-local" class="form-control @error('countdown_date') is-invalid @enderror" id="countdown_date" name="countdown_date" value="{{ old('countdown_date') }}">
                                            @error('countdown_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-light border mb-3" style="border-left: 4px solid #f093fb !important;">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle text-info me-1"></i>
                                            Set when the countdown timer should expire. Multiple products can share the same countdown date.
                                        </small>
                                    </div>
                                    
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" onclick="setCommonCountdown()">
                                            <i class="fas fa-calendar-alt me-1"></i> Set Common Sale End Date
                                        </button>
                                        <small class="text-muted">
                                            <i class="fas fa-bolt text-warning"></i> Quick set for seasonal sales
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>

                        <!-- ============================================ -->
                        <!-- SUBMIT ACTIONS -->
                        <!-- ============================================ -->
                        <div class="section-divider mt-5 pt-4" style="border-top: 3px solid #e3e6f0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-info-circle text-info"></i> All fields marked with <span class="text-danger">*</span> are required
                                    </p>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg shadow-sm" id="create-product-btn">
                                        <i class="fas fa-save me-1"></i> Create Product
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Section Divider Styles */
.section-divider {
    position: relative;
    padding: 1.5rem 0;
}

.section-divider:not(:last-child):after {
    content: '';
    position: absolute;
    bottom: -1rem;
    left: 50%;
    transform: translateX(-50%);
    width: 80%;
    height: 2px;
    background: linear-gradient(90deg, transparent, #e3e6f0, transparent);
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.section-title .badge {
    font-size: 0.875rem;
}

.bg-purple {
    background-color: #6f42c1 !important;
}

/* Card Enhancements */
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

/* Form Control Enhancements */
.form-control:focus,
.form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

/* Better spacing for form groups */
.mb-4 {
    margin-bottom: 1.5rem !important;
}

/* Improve button spacing */
.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

/* Badge improvements */
.badge-sm {
    font-size: 0.7rem;
    padding: 0.25em 0.6em;
}
</style>

<script>
// Simple Gallery System
let galleryImages = [];

document.addEventListener('DOMContentLoaded', function() {
    console.log('🖼️ Simple gallery system loaded');

    const galleryInput = document.getElementById('gallery-images');
    if (galleryInput) {
        galleryInput.addEventListener('change', function(event) {
            console.log('📸 Files selected:', event.target.files.length);
            const files = Array.from(event.target.files);
            galleryImages = [...galleryImages, ...files];
            updateGalleryPreview();
        });
    }
});

function updateGalleryPreview() {
    console.log('🖼️ Updating gallery preview with', galleryImages.length, 'images');

    const galleryPreview = document.getElementById('gallery-preview');
    const galleryGrid = document.getElementById('gallery-grid');
    const galleryCount = document.getElementById('gallery-count');

    if (galleryImages.length > 0) {
        console.log('✅ Showing gallery preview');

        if (galleryPreview) {
            galleryPreview.style.display = 'block';
        }
        if (galleryCount) {
            galleryCount.textContent = galleryImages.length;
        }
        if (galleryGrid) {
            galleryGrid.innerHTML = '';
        }

        galleryImages.forEach((file, index) => {
            console.log('📸 Processing image', index + 1, ':', file.name);

            const reader = new FileReader();
            reader.onload = function(e) {
                console.log('✅ Image loaded:', file.name);

                if (galleryGrid) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 col-sm-4 col-6';
                    col.innerHTML = `
                        <div style="border: 1px solid #ddd; border-radius: 8px; padding: 8px; background: white;">
                            <img src="${e.target.result}" alt="${file.name}" style="width: 100%; height: 100px; object-fit: cover; border-radius: 4px;">
                            <div style="margin-top: 8px; font-size: 12px; color: #666;">
                                ${file.name}
                            </div>
                        </div>
                    `;
                    galleryGrid.appendChild(col);
                    console.log('✅ Image added to grid:', file.name);
                }
            };
            reader.readAsDataURL(file);
        });
    } else {
        console.log('❌ Hiding gallery preview - no images');
        if (galleryPreview) {
            galleryPreview.style.display = 'none';
        }
    }
}

// Function to set common countdown dates
function setCommonCountdown() {
    const enableCheckbox = document.getElementById('enable_countdown');
    const dateInput = document.getElementById('countdown_date');

    // Enable countdown
    enableCheckbox.checked = true;

    // Set common sale end dates (30 days from now, 60 days, 90 days)
    const now = new Date();
    const options = [
        { days: 30, label: '30 days (1 month)' },
        { days: 60, label: '60 days (2 months)' },
        { days: 90, label: '90 days (3 months)' }
    ];

    const choice = prompt(`Choose a common sale end date:\n1. ${options[0].label}\n2. ${options[1].label}\n3. ${options[2].label}\n\nEnter 1, 2, or 3:`);

    if (choice && ['1', '2', '3'].includes(choice)) {
        const selectedOption = options[parseInt(choice) - 1];
        const endDate = new Date(now.getTime() + (selectedOption.days * 24 * 60 * 60 * 1000));

        // Format for datetime-local input
        const year = endDate.getFullYear();
        const month = String(endDate.getMonth() + 1).padStart(2, '0');
        const day = String(endDate.getDate()).padStart(2, '0');
        const hours = String(endDate.getHours()).padStart(2, '0');
        const minutes = String(endDate.getMinutes()).padStart(2, '0');

        dateInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;

        alert(`Countdown set to ${selectedOption.label} from now (${endDate.toLocaleDateString()})`);
    }
}

// Function to set common sale prices
function setCommonSalePrice() {
    console.log('Set Common Sale Price button clicked!'); // Debug log

    const salePriceInput = document.getElementById('sale_price');
    const regularPriceInput = document.getElementById('price');

    // Check if elements exist
    if (!salePriceInput || !regularPriceInput) {
        alert('Error: Form elements not found. Please refresh the page.');
        return;
    }

    // Get current regular price
    const regularPrice = parseFloat(regularPriceInput.value) || 0;

    if (regularPrice <= 0) {
        alert('Please set a regular price first before setting sale price.');
        return;
    }

    // Common sale price options (percentage off)
    const options = [
        { percent: 10, label: '10% off' },
        { percent: 20, label: '20% off' },
        { percent: 30, label: '30% off' },
        { percent: 50, label: '50% off' }
    ];

    // Create a custom popup with better visibility
    const popupMessage = `Choose a common sale price:\n\n1. ${options[0].label} → $${(regularPrice * 0.9).toFixed(2)}\n2. ${options[1].label} → $${(regularPrice * 0.8).toFixed(2)}\n3. ${options[2].label} → $${(regularPrice * 0.7).toFixed(2)}\n4. ${options[3].label} → $${(regularPrice * 0.5).toFixed(2)}\n\nEnter 1, 2, 3, or 4:`;

    console.log('Showing popup with options:', popupMessage); // Debug log

    const choice = prompt(popupMessage);

    console.log('User choice:', choice); // Debug log

    if (choice && ['1', '2', '3', '4'].includes(choice)) {
        const selectedOption = options[parseInt(choice) - 1];
        const salePrice = regularPrice * (1 - selectedOption.percent / 100);

        salePriceInput.value = salePrice.toFixed(2);

        alert(`✅ Sale price set to ${selectedOption.label} ($${salePrice.toFixed(2)})`);
        console.log('Sale price set successfully!', { selectedOption, salePrice }); // Debug log
    } else if (choice !== null) {
        alert('❌ Invalid choice. Please enter 1, 2, 3, or 4.');
        console.log('Invalid choice entered:', choice); // Debug log
    }
}

// Color Management Functions
let selectedColors = [];

// Size Management Functions
let selectedSizes = [];

function addColor() {
    const colorName = document.getElementById('color_name').value.trim();
    const colorHex = document.getElementById('color_hex').value;
    const colorStock = parseInt(document.getElementById('color_stock').value) || 0;

    if (!colorName) {
        alert('Please enter a color name');
        return;
    }

    // Validate stock quantity - must be at least 1
    if (colorStock < 1) {
        alert('❌ Stock quantity must be at least 1 item for each color');
        document.getElementById('color_stock').focus();
        document.getElementById('color_stock').style.borderColor = '#e53e3e';
        document.getElementById('color_stock').style.boxShadow = '0 0 0 2px rgba(229, 62, 62, 0.2)';
        return;
    }

    // Reset stock input styling
    document.getElementById('color_stock').style.borderColor = '#e2e8f0';
    document.getElementById('color_stock').style.boxShadow = 'none';

    // Check if color already exists in this product
    if (selectedColors.some(color => color.name.toLowerCase() === colorName.toLowerCase())) {
        alert('This color has already been added to this product');
        return;
    }

    // Check if this is a NEW color (not in global library)
    const isNewColor = !existingColors.some(c => c.value.toLowerCase() === colorName.toLowerCase());
    
    // Add color to array
    const newColor = {
        name: colorName,
        hex: colorHex,
        stock: parseInt(colorStock),
        isNew: isNewColor
    };

    selectedColors.push(newColor);

    // Show sync notification if it's a new color
    if (isNewColor) {
        showColorSyncNotification(`"${colorName}" will be added to global library when you save!`, 'new');
    } else {
        showColorSyncNotification(`"${colorName}" already exists in library • Reusing existing value`, 'existing');
    }

    // Clear inputs
    document.getElementById('color_name').value = '';
    document.getElementById('color_hex').value = '#000000';
    document.getElementById('color_stock').value = '';

    // Update preview
    updateColorsPreview();

    console.log(isNewColor ? '✨ NEW color added:' : '♻️ Existing color reused:', newColor);
}

function showColorSyncNotification(message, type) {
    const notification = document.getElementById('color-sync-notification');
    const messageSpan = document.getElementById('color-sync-message');
    
    if (!notification || !messageSpan) {
        console.warn('Color sync notification elements not found');
        return;
    }
    
    messageSpan.textContent = message;
    
    if (type === 'new') {
        notification.className = 'alert alert-success border-left mb-3';
        notification.style.borderLeft = '4px solid #28a745';
    } else if (type === 'removed') {
        notification.className = 'alert alert-warning border-left mb-3';
        notification.style.borderLeft = '4px solid #f59e0b';
    } else {
        notification.className = 'alert alert-info border-left mb-3';
        notification.style.borderLeft = '4px solid #17a2b8';
    }
    
    notification.style.display = 'block';
    
    // Auto-hide after 4 seconds
    setTimeout(() => {
        notification.style.display = 'none';
    }, 4000);
}

function addPresetColor(name, hex) {
    document.getElementById('color_name').value = name;
    document.getElementById('color_hex').value = hex;
    document.getElementById('color_stock').value = 10; // Default stock
    addColor();
}

function removeColor(index) {
    const color = selectedColors[index];
    if (confirm(`Are you sure you want to remove "${color.name}" color?`)) {
        selectedColors.splice(index, 1);
        updateColorsPreview();
        console.log('✅ Color removed at index:', index, 'Remaining colors:', selectedColors.length);
        
        // Show success notification
        showColorSyncNotification(`"${color.name}" color removed successfully`, 'removed');
    }
}

function updateColorsPreview() {
    const colorsList = document.getElementById('colors-list');
    const colorInputs = document.getElementById('color-inputs');

    if (selectedColors.length === 0) {
        colorsList.innerHTML = '<span class="text-muted">No colors added yet</span>';
        colorInputs.innerHTML = '';
        return;
    }

    // Update colors list display
    colorsList.innerHTML = '';
    selectedColors.forEach((color, index) => {
        const colorElement = document.createElement('div');
        colorElement.className = 'd-flex align-items-center gap-2 p-2 border rounded';
        colorElement.style.backgroundColor = '#f8f9fa';
        colorElement.innerHTML = `
            <div class="color-dot-preview" style="width: 20px; height: 20px; border-radius: 50%; background-color: ${color.hex}; border: 2px solid #e2e8f0;"></div>
            <span class="fw-bold">${color.name}</span>
            <small class="text-muted">(${color.hex})</small>
            <small class="text-muted">Stock: ${color.stock}</small>
            <button type="button" 
                    class="btn btn-sm btn-danger rounded-pill ms-auto remove-color-btn" 
                    data-color-index="${index}"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    title="Remove this color"
                    style="transition: all 0.3s ease; padding: 0.25rem 0.75rem;">
                <i class="fas fa-trash-alt me-1"></i>Remove
            </button>
        `;
        colorsList.appendChild(colorElement);
    });

    // Update hidden inputs for form submission
    colorInputs.innerHTML = '';
    selectedColors.forEach((color, index) => {
        // Create hidden inputs for each color
        const nameInput = document.createElement('input');
        nameInput.type = 'hidden';
        nameInput.name = `colors[${index}][name]`;
        nameInput.value = color.name;

        const hexInput = document.createElement('input');
        hexInput.type = 'hidden';
        hexInput.name = `colors[${index}][hex]`;
        hexInput.value = color.hex;

        const stockInput = document.createElement('input');
        stockInput.type = 'hidden';
        stockInput.name = `colors[${index}][stock]`;
        stockInput.value = color.stock;

        colorInputs.appendChild(nameInput);
        colorInputs.appendChild(hexInput);
        colorInputs.appendChild(stockInput);
    });

    // Reinitialize tooltips after updating the DOM
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Size Management Functions
function addSize() {
    const sizeName = document.getElementById('size_name').value.trim();
    const sizeStock = parseInt(document.getElementById('size_stock').value) || 0;
    const sizeGuide = document.getElementById('size_guide').value.trim();

    if (!sizeName) {
        alert('Please enter a size name');
        return;
    }

    // Validate stock quantity - must be at least 1
    if (sizeStock < 1) {
        alert('❌ Stock quantity must be at least 1 item for each size');
        document.getElementById('size_stock').focus();
        document.getElementById('size_stock').style.borderColor = '#e53e3e';
        document.getElementById('size_stock').style.boxShadow = '0 0 0 2px rgba(229, 62, 62, 0.2)';
        return;
    }

    // Reset stock input styling
    document.getElementById('size_stock').style.borderColor = '#e2e8f0';
    document.getElementById('size_stock').style.boxShadow = 'none';

    // Check if size already exists in this product
    if (selectedSizes.some(size => size.name.toLowerCase() === sizeName.toLowerCase())) {
        alert('This size has already been added to this product');
        return;
    }

    // Check if this is a NEW size (not in global library)
    const isNewSize = !existingSizes.some(s => s.value.toLowerCase() === sizeName.toLowerCase());
    
    // Add size to array
    const newSize = {
        name: sizeName,
        stock: parseInt(sizeStock),
        guide: sizeGuide,
        isNew: isNewSize
    };

    selectedSizes.push(newSize);

    // Show sync notification if it's a new size
    if (isNewSize) {
        showSizeSyncNotification(`"${sizeName}" will be added to global library when you save!`, 'new');
    } else {
        showSizeSyncNotification(`"${sizeName}" already exists in library • Reusing existing value`, 'existing');
    }

    // Clear inputs
    document.getElementById('size_name').value = '';
    document.getElementById('size_stock').value = '';
    document.getElementById('size_guide').value = '';

    // Update preview
    updateSizesPreview();

    console.log(isNewSize ? '✨ NEW size added:' : '♻️ Existing size reused:', newSize);
}

function showSizeSyncNotification(message, type) {
    const notification = document.getElementById('size-sync-notification');
    const messageSpan = document.getElementById('size-sync-message');
    
    if (!notification || !messageSpan) {
        console.warn('Size sync notification elements not found');
        return;
    }
    
    messageSpan.textContent = message;
    
    if (type === 'new') {
        notification.className = 'alert alert-success border-left mb-3';
        notification.style.borderLeft = '4px solid #28a745';
    } else if (type === 'removed') {
        notification.className = 'alert alert-warning border-left mb-3';
        notification.style.borderLeft = '4px solid #f59e0b';
    } else {
        notification.className = 'alert alert-info border-left mb-3';
        notification.style.borderLeft = '4px solid #17a2b8';
    }
    
    notification.style.display = 'block';
    
    // Auto-hide after 4 seconds
    setTimeout(() => {
        notification.style.display = 'none';
    }, 4000);
}

function addPresetSize(name, guide) {
    document.getElementById('size_name').value = name;
    document.getElementById('size_guide').value = guide;
    document.getElementById('size_stock').value = 10; // Default stock
    addSize();
}

function removeSize(index) {
    const size = selectedSizes[index];
    if (confirm(`Are you sure you want to remove size "${size.name}"?`)) {
        selectedSizes.splice(index, 1);
        updateSizesPreview();
        console.log('✅ Size removed at index:', index, 'Remaining sizes:', selectedSizes.length);
        
        // Show success notification
        showSizeSyncNotification(`"${size.name}" size removed successfully`, 'removed');
    }
}

function updateSizesPreview() {
    const sizesList = document.getElementById('sizes-list');
    const sizeInputs = document.getElementById('size-inputs');

    if (selectedSizes.length === 0) {
        sizesList.innerHTML = '<span class="text-muted">No sizes added yet</span>';
        sizeInputs.innerHTML = '';
        return;
    }

    // Update sizes list display
    sizesList.innerHTML = '';
    selectedSizes.forEach((size, index) => {
        const sizeElement = document.createElement('div');
        sizeElement.className = 'd-flex align-items-center gap-2 p-2 border rounded';
        sizeElement.style.backgroundColor = '#f8f9fa';
        sizeElement.innerHTML = `
            <span class="fw-bold">${size.name}</span>
            <small class="text-muted">Stock: ${size.stock}</small>
            ${size.guide ? `<small class="text-muted">Guide: ${size.guide}</small>` : ''}
            <button type="button" 
                    class="btn btn-sm btn-danger rounded-pill ms-auto remove-size-btn" 
                    data-size-index="${index}"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    title="Remove this size"
                    style="transition: all 0.3s ease; padding: 0.25rem 0.75rem;">
                <i class="fas fa-trash-alt me-1"></i>Remove
            </button>
        `;
        sizesList.appendChild(sizeElement);
    });

    // Update hidden inputs for form submission
    sizeInputs.innerHTML = '';
    selectedSizes.forEach((size, index) => {
        // Create hidden inputs for each size
        const nameInput = document.createElement('input');
        nameInput.type = 'hidden';
        nameInput.name = `sizes[${index}][name]`;
        nameInput.value = size.name;

        const stockInput = document.createElement('input');
        stockInput.type = 'hidden';
        stockInput.name = `sizes[${index}][stock]`;
        stockInput.value = size.stock;

        const guideInput = document.createElement('input');
        guideInput.type = 'hidden';
        guideInput.name = `sizes[${index}][guide]`;
        guideInput.value = size.guide;

        sizeInputs.appendChild(nameInput);
        sizeInputs.appendChild(stockInput);
        sizeInputs.appendChild(guideInput);
    });

    // Reinitialize tooltips after updating the DOM
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// ================================================================
// ATTRIBUTE INTEGRATION SYSTEM - Connects to Attribute Management
// ================================================================

let existingColors = [];
let existingSizes = [];

// Load existing colors and sizes from database
async function loadAttributeData() {
    try {
        // Load colors from API
        const colorResponse = await fetch('{{ route('api.attributes.values', 'color') }}');
        if (colorResponse.ok) {
            const colorData = await colorResponse.json();
            existingColors = colorData.values || [];
            populateColorAutocomplete();
        }

        // Load popular colors
        const popularColorsResponse = await fetch('{{ route('api.attributes.popular', 'color') }}');
        if (popularColorsResponse.ok) {
            const popularData = await popularColorsResponse.json();
            showPopularColors(popularData.popular_values || []);
        }

        // Load sizes from API
        const sizeResponse = await fetch('{{ route('api.attributes.values', 'size') }}');
        if (sizeResponse.ok) {
            const sizeData = await sizeResponse.json();
            existingSizes = sizeData.values || [];
            populateSizeAutocomplete();
        }

        // Load popular sizes
        const popularSizesResponse = await fetch('{{ route('api.attributes.popular', 'size') }}');
        if (popularSizesResponse.ok) {
            const popularData = await popularSizesResponse.json();
            showPopularSizes(popularData.popular_values || []);
        }

        console.log('✅ Attribute data loaded:', { colors: existingColors.length, sizes: existingSizes.length });
    } catch (error) {
        console.error('❌ Error loading attribute data:', error);
    }
}

// Populate color autocomplete datalist
function populateColorAutocomplete() {
    const datalist = document.getElementById('existing-colors');
    datalist.innerHTML = '';
    
    existingColors.forEach(color => {
        const option = document.createElement('option');
        option.value = color.value;
        option.setAttribute('data-hex', color.hex_code || '#000000');
        option.setAttribute('data-usage', color.usage_count || 0);
        datalist.appendChild(option);
    });
}

// Populate size autocomplete datalist
function populateSizeAutocomplete() {
    const datalist = document.getElementById('existing-sizes');
    datalist.innerHTML = '';
    
    existingSizes.forEach(size => {
        const option = document.createElement('option');
        option.value = size.value;
        option.setAttribute('data-usage', size.usage_count || 0);
        datalist.appendChild(option);
    });
}

// Show popular colors as quick-select buttons
function showPopularColors(colors) {
    if (colors.length === 0) return;
    
    const section = document.getElementById('popular-colors-section');
    const list = document.getElementById('popular-colors-list');
    list.innerHTML = '';
    
    colors.slice(0, 8).forEach(color => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'btn btn-sm btn-outline-secondary';
        btn.innerHTML = `
            <span class="d-inline-block me-1" style="width: 12px; height: 12px; background: ${color.hex_code}; border: 1px solid #ddd; border-radius: 2px;"></span>
            ${color.value} <small class="text-muted">(${color.usage_count} products)</small>
        `;
        btn.onclick = () => quickAddColor(color.value, color.hex_code);
        list.appendChild(btn);
    });
    
    section.style.display = 'block';
}

// Show popular sizes as quick-select buttons
function showPopularSizes(sizes) {
    if (sizes.length === 0) return;
    
    const section = document.getElementById('popular-sizes-section');
    const list = document.getElementById('popular-sizes-list');
    list.innerHTML = '';
    
    sizes.slice(0, 8).forEach(size => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'btn btn-sm btn-outline-secondary';
        btn.innerHTML = `${size.value} <small class="text-muted">(${size.usage_count} products)</small>`;
        btn.onclick = () => quickAddSize(size.value);
        list.appendChild(btn);
    });
    
    section.style.display = 'block';
}

// Quick add color from popular list
function quickAddColor(name, hex) {
    document.getElementById('color_name').value = name;
    document.getElementById('color_hex').value = hex || '#000000';
    document.getElementById('color_stock').value = 10;
    document.getElementById('color_stock').focus();
}

// Quick add size from popular list
function quickAddSize(name) {
    document.getElementById('size_name').value = name;
    document.getElementById('size_stock').value = 10;
    document.getElementById('size_stock').focus();
}

// Auto-fill hex code when existing color is selected
document.addEventListener('input', function(e) {
    if (e.target.id === 'color_name') {
        const colorName = e.target.value;
        const existingColor = existingColors.find(c => c.value.toLowerCase() === colorName.toLowerCase());
        if (existingColor && existingColor.hex_code) {
            document.getElementById('color_hex').value = existingColor.hex_code;
            console.log(`✅ Auto-filled hex code for "${colorName}":`, existingColor.hex_code);
        }
    }
});

// New Arrival Auto-Remove Functionality
document.addEventListener('DOMContentLoaded', function() {
    updateColorsPreview();
    updateSizesPreview();
    
    // Load attribute data from database
    loadAttributeData();
    
    // Event delegation for remove buttons
    document.addEventListener('click', function(e) {
        // Handle color remove button clicks
        if (e.target.closest('.remove-color-btn')) {
            const button = e.target.closest('.remove-color-btn');
            const index = parseInt(button.getAttribute('data-color-index'));
            removeColor(index);
        }
        
        // Handle size remove button clicks
        if (e.target.closest('.remove-size-btn')) {
            const button = e.target.closest('.remove-size-btn');
            const index = parseInt(button.getAttribute('data-size-index'));
            removeSize(index);
        }
    });

    // Handle new arrival checkbox
    const newArrivalCheckbox = document.getElementById('is_new_arrival');
    const newArrivalInfo = document.getElementById('new-arrival-info');

    if (newArrivalCheckbox && newArrivalInfo) {
        newArrivalCheckbox.addEventListener('change', function() {
            if (this.checked) {
                newArrivalInfo.style.display = 'block';
            } else {
                newArrivalInfo.style.display = 'none';
            }
        });

        // Show info if checkbox is already checked (from old values)
        if (newArrivalCheckbox.checked) {
            newArrivalInfo.style.display = 'block';
        }
    }

    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection
        