@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Edit Product</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Basic Information Fields (Shared Component) --}}
                        @include('admin.products.partials._basic_fields', ['product' => $product, 'categories' => $categories, 'brands' => $brands])

                        {{-- Price and Stock Fields (Shared Component) --}}
                        @include('admin.products.partials._price_fields', ['product' => $product])

                        <!-- Primary Image -->
                        <div class="mb-4">
                            <label for="image" class="form-label">Primary Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                            @if($product->image)
                                <div class="mt-2">
                                    <small class="text-muted">Current image:</small>
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Current image" style="max-width: 100px; max-height: 100px; object-fit: cover;" class="img-thumbnail">
                                </div>
                            @endif
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gallery Images -->
                        <div class="mb-4">
                            <label class="form-label">Gallery Images</label>
                            <input type="file" id="gallery-images" name="gallery_images[]" accept="image/*" multiple class="form-control @error('gallery_images') is-invalid @enderror">
                            <small class="form-text text-muted">Select multiple images for the gallery (JPG, PNG, WebP - max 5MB each)</small>
                            @if($product->gallery_images)
                                <div class="mt-2">
                                    <small class="text-muted">Current gallery images:</small>
                                    <div class="row g-2 mt-1">
                                        @foreach($product->gallery_images as $galleryImage)
                                            <div class="col-md-3 col-sm-4 col-6">
                                                <img src="{{ asset('storage/' . $galleryImage) }}" alt="Gallery image" style="width: 100%; height: 100px; object-fit: cover;" class="img-thumbnail">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @error('gallery_images')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gallery Preview -->
                        <div id="gallery-preview" style="display: none; border: 1px solid #ddd; padding: 1rem; border-radius: 8px; background: #f8f9fa; margin-top: 1rem;">
                            <h6>Gallery Preview (<span id="gallery-count">0</span> images)</h6>
                            <div id="gallery-grid" class="row g-2"></div>
                        </div>

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

                                    <!-- Database Connection Status -->
                                    <div id="database-status" class="alert alert-info border-left mb-3" style="border-left: 4px solid #17a2b8 !important;">
                                        <i class="fas fa-database me-1"></i>
                                        <strong>Database Status:</strong> 
                                        <span id="database-message">Loading colors and sizes from database...</span>
                                    </div>

                                    <!-- Auto-Sync Notification -->
                                    <div id="color-sync-notification" class="alert alert-success border-left" style="display:none; border-left: 4px solid #28a745 !important;">
                                        <i class="fas fa-sync-alt me-1"></i>
                                        <strong>Auto-Sync Active:</strong> 
                                        <span id="color-sync-message">New colors will be added to your global color library automatically!</span>
                                    </div>

                                    <!-- Current Colors Display -->
                                    @php
                                        $currentColors = $product->productAttributes()
                                            ->whereHas('attributeValue.attribute', function($q) {
                                                $q->where('slug', 'color');
                                            })
                                            ->with('attributeValue')
                                            ->get();
                                    @endphp

                                    @if($currentColors->count() > 0)
                                        <div class="mb-3">
                                            <h6>Current Colors:</h6>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($currentColors as $colorAttr)
                                                    @php
                                                        $colorValue = $colorAttr->attributeValue->value;
                                                        $colorMap = [
                                                            'black' => '#000000', 'white' => '#ffffff', 'red' => '#ff0000',
                                                            'blue' => '#0000ff', 'green' => '#00ff00', 'yellow' => '#ffff00',
                                                            'pink' => '#ffc0cb', 'gray' => '#808080', 'brown' => '#a52a2a',
                                                            'navy' => '#000080', 'purple' => '#800080', 'orange' => '#ffa500'
                                                        ];
                                                        $colorHex = $colorMap[strtolower($colorValue)] ?? '#cccccc';
                                                    @endphp
                                                    <div class="d-flex align-items-center gap-2 p-2 border rounded" style="background-color: #f8f9fa;">
                                                        <div style="width: 20px; height: 20px; border-radius: 50%; background-color: {{ $colorHex }}; border: 2px solid #e2e8f0;"></div>
                                                        <span class="fw-bold">{{ $colorValue }}</span>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeExistingColor({{ $colorAttr->id }})">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

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
                                            <input type="number" class="form-control" id="color_stock" placeholder="Quantity" min="1" value="1" required>
                                            <small class="text-muted">Minimum 1 item required</small>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-primary w-100" onclick="addColor()">
                                                <i class="fas fa-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Debug Test Buttons -->
                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <small class="text-muted">Debug: </small>
                                            <button type="button" class="btn btn-sm btn-outline-info" onclick="testAddColor()">Test Color Function</button>
                                            <button type="button" class="btn btn-sm btn-outline-info" onclick="testAddSize()">Test Size Function</button>
                                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="logArrays()">Log Arrays</button>
                                        </div>
                                    </div>

                                    <!-- Color Preview Section -->
                                    <div id="colors-preview" class="mb-3">
                                        <h6>New Colors to Add:</h6>
                                        <div id="colors-list" class="d-flex flex-wrap gap-2">
                                            <span class="text-muted">No new colors added yet</span>
                                        </div>
                                    </div>

                                    <!-- Hidden inputs for form submission -->
                                    <div id="color-inputs"></div>
                                    
                                    <!-- Color Sync Notification -->
                                    <div id="color-sync-notification" class="alert alert-info border-left mb-3" style="display: none;">
                                        <i class="fas fa-sync-alt me-2"></i>
                                        <span id="color-sync-message">Color management notification</span>
                                    </div>
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

                                    <!-- Current Sizes Display -->
                                    @php
                                        $currentSizes = $product->productAttributes()
                                            ->whereHas('attributeValue.attribute', function($q) {
                                                $q->where('slug', 'size');
                                            })
                                            ->with('attributeValue')
                                            ->get();
                                    @endphp

                                    @if($currentSizes->count() > 0)
                                        <div class="mb-3">
                                            <h6>Current Sizes:</h6>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($currentSizes as $sizeAttr)
                                                    @php
                                                        $sizeValue = $sizeAttr->attributeValue->value;
                                                    @endphp
                                                    <div class="d-flex align-items-center gap-2 p-2 border rounded" style="background-color: #f8f9fa;">
                                                        <span class="fw-bold">{{ $sizeValue }}</span>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeExistingSize({{ $sizeAttr->id }})">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

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
                                            <input type="number" class="form-control" id="size_stock" placeholder="Quantity" min="1" value="1" required>
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
                                        <h6>New Sizes:</h6>
                                        <div id="sizes-list" class="d-flex flex-wrap gap-2">
                                            <span class="text-muted">No new sizes added yet</span>
                                        </div>
                                    </div>

                                    <!-- Hidden inputs for form submission -->
                                    <div id="size-inputs"></div>
                                    
                                    <!-- Size Sync Notification -->
                                    <div id="size-sync-notification" class="alert alert-info border-left mb-3" style="display: none;">
                                        <i class="fas fa-sync-alt me-2"></i>
                                        <span id="size-sync-message">Size management notification</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input type="hidden" name="status" value="0">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status', $product->status == 'active') ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">
                                    Active
                                </label>
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
                                                    <input class="form-check-input" type="checkbox" id="is_new_arrival" name="is_new_arrival" value="1" {{ old('is_new_arrival', $product->is_new_arrival) ? 'checked' : '' }}>
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
                                                    <input class="form-check-input" type="checkbox" id="featured_new_arrival" name="featured_new_arrival" value="1" {{ old('featured_new_arrival', $product->featured_new_arrival) ? 'checked' : '' }}>
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
                                            <input type="datetime-local" class="form-control @error('new_arrival_until') is-invalid @enderror" id="new_arrival_until" name="new_arrival_until" value="{{ old('new_arrival_until', $product->new_arrival_until ? $product->new_arrival_until->format('Y-m-d\TH:i') : '') }}">
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
                                                <option value="0" {{ old('new_arrival_priority', $product->new_arrival_priority ?? 0) == 0 ? 'selected' : '' }}>⚪ Normal (0)</option>
                                                <option value="1" {{ old('new_arrival_priority', $product->new_arrival_priority ?? 0) == 1 ? 'selected' : '' }}>🟡 Low (1)</option>
                                                <option value="3" {{ old('new_arrival_priority', $product->new_arrival_priority ?? 0) == 3 ? 'selected' : '' }}>🟠 Medium (3)</option>
                                                <option value="5" {{ old('new_arrival_priority', $product->new_arrival_priority ?? 0) == 5 ? 'selected' : '' }}>🔴 High (5)</option>
                                                <option value="10" {{ old('new_arrival_priority', $product->new_arrival_priority ?? 0) == 10 ? 'selected' : '' }}>⭐ Highest (10)</option>
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
                                        <strong>Current Status:</strong>
                                        @if($product->is_currently_new_arrival)
                                            <span class="badge bg-success">Currently showing as New Arrival</span>
                                        @else
                                            <span class="badge bg-secondary">Not currently showing as New Arrival</span>
                                        @endif
                                        @if($product->created_at->diffInDays() < 30)
                                            <br><small>Product was created {{ $product->created_at->diffForHumans() }} (auto-qualifies)</small>
                                        @endif
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
                                                    <input class="form-check-input" type="checkbox" id="enable_countdown" name="enable_countdown" value="1" {{ old('enable_countdown', $product->enable_countdown) ? 'checked' : '' }}>
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
                                            <input type="datetime-local" class="form-control @error('countdown_date') is-invalid @enderror" id="countdown_date" name="countdown_date" value="{{ old('countdown_date', $product->countdown_date ? $product->countdown_date->format('Y-m-d\TH:i') : '') }}">
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

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary" id="update-product-btn">Update Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.form-control {
    border-radius: 6px !important;
    border: 2px solid #e2e8f0 !important;
    font-size: 13px !important;
    transition: all 0.3s ease !important;
}

.form-control:focus {
    border-color: #4299e1 !important;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1) !important;
}

.btn {
    transition: all 0.3s ease !important;
}

.btn:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
}

.product-stats {
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); }
    50% { box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5); }
    100% { box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); }
}
</style>
@endpush

<script>
console.log('🔄 Edit page JavaScript loaded');

// Global variables
let selectedColors = [];
let selectedSizes = [];
let existingColors = [];
let existingSizes = [];

// Core Functions - Defined First
function addColor() {
    const colorName = document.getElementById('color_name').value.trim();
    const colorHex = document.getElementById('color_hex').value;
    let colorStock = parseInt(document.getElementById('color_stock').value) || 0;
    
    if (colorStock <= 0) colorStock = 1;
    if (!colorName) { alert('Please enter a color name'); return; }
    if (colorStock < 1) { alert('Stock quantity must be at least 1'); return; }
    if (selectedColors.some(color => color.name.toLowerCase() === colorName.toLowerCase())) {
        alert('This color has already been added'); return;
    }

    const newColor = { name: colorName, hex: colorHex, stock: colorStock };
    selectedColors.push(newColor);
    
    document.getElementById('color_name').value = '';
    document.getElementById('color_hex').value = '#000000';
    document.getElementById('color_stock').value = '1';
    
    updateColorsPreview();
    console.log('Color added:', newColor);
}

function addSize() {
    const sizeName = document.getElementById('size_name').value.trim();
    let sizeStock = parseInt(document.getElementById('size_stock').value) || 0;
    const sizeGuide = document.getElementById('size_guide').value.trim();
    
    if (sizeStock <= 0) sizeStock = 1;
    if (!sizeName) { alert('Please enter a size name'); return; }
    if (sizeStock < 1) { alert('Stock quantity must be at least 1'); return; }
    if (selectedSizes.some(size => size.name.toLowerCase() === sizeName.toLowerCase())) {
        alert('This size has already been added'); return;
    }

    const newSize = { name: sizeName, stock: sizeStock, guide: sizeGuide };
    selectedSizes.push(newSize);
    
    document.getElementById('size_name').value = '';
    document.getElementById('size_stock').value = '1';
    document.getElementById('size_guide').value = '';
    
    updateSizesPreview();
    console.log('Size added:', newSize);
}

function removeColor(index) {
    if (confirm('Remove this color?')) {
        selectedColors.splice(index, 1);
        updateColorsPreview();
    }
}

function removeSize(index) {
    if (confirm('Remove this size?')) {
        selectedSizes.splice(index, 1);
        updateSizesPreview();
    }
}

function removeExistingColor(colorId) {
    if (confirm('Remove this color?')) {
        const deleteInput = document.createElement('input');
        deleteInput.type = 'hidden';
        deleteInput.name = 'delete_colors[]';
        deleteInput.value = colorId;
        document.getElementById('color-inputs').appendChild(deleteInput);
        event.target.closest('.d-flex').remove();
    }
}

function removeExistingSize(sizeId) {
    if (confirm('Remove this size?')) {
        const deleteInput = document.createElement('input');
        deleteInput.type = 'hidden';
        deleteInput.name = 'delete_sizes[]';
        deleteInput.value = sizeId;
        document.getElementById('size-inputs').appendChild(deleteInput);
        event.target.closest('.d-flex').remove();
    }
}

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

// Helper Functions
function updateColorsPreview() {
    const colorsList = document.getElementById('colors-list');
    const colorInputs = document.getElementById('color-inputs');
    
    if (selectedColors.length === 0) {
        colorsList.innerHTML = '<span class="text-muted">No colors added yet</span>';
        colorInputs.innerHTML = '';
        return;
    }

    colorsList.innerHTML = '';
    selectedColors.forEach((color, index) => {
        const colorElement = document.createElement('div');
        colorElement.className = 'd-flex align-items-center gap-2 p-2 border rounded';
        colorElement.style.backgroundColor = '#f8f9fa';
        colorElement.innerHTML = `
            <div style="width: 20px; height: 20px; border-radius: 50%; background-color: ${color.hex}; border: 2px solid #e2e8f0;"></div>
            <span class="fw-bold">${color.name}</span>
            <small class="text-muted">(${color.hex})</small>
            <small class="text-muted">Stock: ${color.stock}</small>
            <button type="button" class="btn btn-sm btn-danger rounded-pill ms-auto" onclick="removeColor(${index})">Remove</button>
        `;
        colorsList.appendChild(colorElement);
    });
    
    colorInputs.innerHTML = '';
    selectedColors.forEach((color, index) => {
        ['name', 'hex', 'stock'].forEach(field => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `colors[${index}][${field}]`;
            input.value = color[field];
            colorInputs.appendChild(input);
        });
    });
}

function updateSizesPreview() {
    const sizesList = document.getElementById('sizes-list');
    const sizeInputs = document.getElementById('size-inputs');
    
    if (selectedSizes.length === 0) {
        sizesList.innerHTML = '<span class="text-muted">No sizes added yet</span>';
        sizeInputs.innerHTML = '';
        return;
    }
    
    sizesList.innerHTML = '';
    selectedSizes.forEach((size, index) => {
        const sizeElement = document.createElement('div');
        sizeElement.className = 'd-flex align-items-center gap-2 p-2 border rounded';
        sizeElement.style.backgroundColor = '#f8f9fa';
        sizeElement.innerHTML = `
            <span class="fw-bold">${size.name}</span>
            <small class="text-muted">Stock: ${size.stock}</small>
            ${size.guide ? `<small class="text-muted">Guide: ${size.guide}</small>` : ''}
            <button type="button" class="btn btn-sm btn-danger rounded-pill ms-auto" onclick="removeSize(${index})">Remove</button>
        `;
        sizesList.appendChild(sizeElement);
    });
    
    sizeInputs.innerHTML = '';
    selectedSizes.forEach((size, index) => {
        ['name', 'stock', 'guide'].forEach(field => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `sizes[${index}][${field}]`;
            input.value = size[field];
            sizeInputs.appendChild(input);
        });
    });
}

// Gallery System
let galleryImages = [];

document.addEventListener('DOMContentLoaded', function() {
    const galleryInput = document.getElementById('gallery-images');
    if (galleryInput) {
        galleryInput.addEventListener('change', function(event) {
            const files = Array.from(event.target.files);
            galleryImages = [...galleryImages, ...files];
            updateGalleryPreview();
        });
    }
    
    // Load existing colors and sizes from database
    loadAttributeData();
    
    updateColorsPreview();
    updateSizesPreview();
});

// Load existing colors and sizes from database
async function loadAttributeData() {
    try {
        console.log('🔄 Loading attribute data from database...');
        
        // Load colors from API
        const colorResponse = await fetch('/admin/api/attributes/color/values');
        if (colorResponse.ok) {
            const colorData = await colorResponse.json();
            existingColors = colorData.values || [];
            populateColorAutocomplete();
            console.log('✅ Colors loaded:', existingColors.length);
        } else {
            console.warn('⚠️ Failed to load colors:', colorResponse.status);
        }

        // Load popular colors
        const popularColorsResponse = await fetch('/admin/api/attributes/color/popular');
        if (popularColorsResponse.ok) {
            const popularData = await popularColorsResponse.json();
            showPopularColors(popularData.popular_values || []);
            console.log('✅ Popular colors loaded');
        }

        // Load sizes from API
        const sizeResponse = await fetch('/admin/api/attributes/size/values');
        if (sizeResponse.ok) {
            const sizeData = await sizeResponse.json();
            existingSizes = sizeData.values || [];
            populateSizeAutocomplete();
            console.log('✅ Sizes loaded:', existingSizes.length);
        } else {
            console.warn('⚠️ Failed to load sizes:', sizeResponse.status);
        }

        // Load popular sizes
        const popularSizesResponse = await fetch('/admin/api/attributes/size/popular');
        if (popularSizesResponse.ok) {
            const popularData = await popularSizesResponse.json();
            showPopularSizes(popularData.popular_values || []);
            console.log('✅ Popular sizes loaded');
        }

        console.log('✅ Attribute data loaded successfully');
        console.log('📊 Database Summary:');
        console.log('   - Colors available:', existingColors.length);
        console.log('   - Sizes available:', existingSizes.length);
        console.log('   - Color names:', existingColors.map(c => c.value).join(', '));
        console.log('   - Size names:', existingSizes.map(s => s.value).join(', '));
        
        // Update database status in UI
        updateDatabaseStatus('success', `✅ Database connected! Found ${existingColors.length} colors and ${existingSizes.length} sizes.`);
    } catch (error) {
        console.error('❌ Error loading attribute data:', error);
        console.log('🔧 Troubleshooting:');
        console.log('   1. Check if database is connected');
        console.log('   2. Run: php artisan db:seed --class=AttributeSeeder');
        console.log('   3. Check if attributes table exists');
        console.log('   4. Verify API routes are working');
        
        // Update database status in UI
        updateDatabaseStatus('error', '❌ Database connection failed. Check console for details.');
    }
}

// Update database status in UI
function updateDatabaseStatus(type, message) {
    const statusDiv = document.getElementById('database-status');
    const messageSpan = document.getElementById('database-message');
    
    if (statusDiv && messageSpan) {
        messageSpan.textContent = message;
        
        if (type === 'success') {
            statusDiv.className = 'alert alert-success border-left mb-3';
            statusDiv.style.borderLeft = '4px solid #28a745';
        } else if (type === 'error') {
            statusDiv.className = 'alert alert-danger border-left mb-3';
            statusDiv.style.borderLeft = '4px solid #dc3545';
        } else {
            statusDiv.className = 'alert alert-info border-left mb-3';
            statusDiv.style.borderLeft = '4px solid #17a2b8';
        }
    }
}

// Populate color autocomplete datalist
function populateColorAutocomplete() {
    const datalist = document.getElementById('existing-colors');
    if (!datalist) return;
    
    datalist.innerHTML = '';
    existingColors.forEach(color => {
        const option = document.createElement('option');
        option.value = color.value;
        option.setAttribute('data-hex', color.hex_code || '#000000');
        option.setAttribute('data-usage', color.usage_count || 0);
        datalist.appendChild(option);
    });
    console.log('✅ Color autocomplete populated with', existingColors.length, 'colors');
}

// Populate size autocomplete datalist
function populateSizeAutocomplete() {
    const datalist = document.getElementById('existing-sizes');
    if (!datalist) return;
    
    datalist.innerHTML = '';
    existingSizes.forEach(size => {
        const option = document.createElement('option');
        option.value = size.value;
        option.setAttribute('data-usage', size.usage_count || 0);
        datalist.appendChild(option);
    });
    console.log('✅ Size autocomplete populated with', existingSizes.length, 'sizes');
}

// Show popular colors as quick-select buttons
function showPopularColors(colors) {
    if (colors.length === 0) return;
    
    const section = document.getElementById('popular-colors-section');
    const list = document.getElementById('popular-colors-list');
    if (!section || !list) return;
    
    list.innerHTML = '';
    colors.slice(0, 8).forEach(color => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'btn btn-sm btn-outline-secondary me-2 mb-2';
        btn.innerHTML = `
            <span class="d-inline-block me-1" style="width: 12px; height: 12px; background: ${color.hex_code || '#cccccc'}; border: 1px solid #ddd; border-radius: 2px;"></span>
            ${color.value} <small class="text-muted">(${color.usage_count} products)</small>
        `;
        btn.onclick = () => quickAddColor(color.value, color.hex_code);
        list.appendChild(btn);
    });
    
    section.style.display = 'block';
    console.log('✅ Popular colors displayed:', colors.length);
}

// Show popular sizes as quick-select buttons
function showPopularSizes(sizes) {
    if (sizes.length === 0) return;
    
    const section = document.getElementById('popular-sizes-section');
    const list = document.getElementById('popular-sizes-list');
    if (!section || !list) return;
    
    list.innerHTML = '';
    sizes.slice(0, 8).forEach(size => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'btn btn-sm btn-outline-secondary me-2 mb-2';
        btn.innerHTML = `${size.value} <small class="text-muted">(${size.usage_count} products)</small>`;
        btn.onclick = () => quickAddSize(size.value);
        list.appendChild(btn);
    });
    
    section.style.display = 'block';
    console.log('✅ Popular sizes displayed:', sizes.length);
}

// Quick add color from popular list
function quickAddColor(name, hex) {
    document.getElementById('color_name').value = name;
    document.getElementById('color_hex').value = hex || '#000000';
    document.getElementById('color_stock').value = '1';
    document.getElementById('color_stock').focus();
    console.log('✅ Quick add color:', name, hex);
}

// Quick add size from popular list
function quickAddSize(name) {
    document.getElementById('size_name').value = name;
    document.getElementById('size_stock').value = '1';
    document.getElementById('size_stock').focus();
    console.log('✅ Quick add size:', name);
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

function updateGalleryPreview() {
    const galleryPreview = document.getElementById('gallery-preview');
    const galleryGrid = document.getElementById('gallery-grid');
    const galleryCount = document.getElementById('gallery-count');

    if (galleryImages.length > 0) {
        galleryPreview.style.display = 'block';
        galleryCount.textContent = galleryImages.length;
        galleryGrid.innerHTML = '';

        galleryImages.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-3 col-sm-4 col-6';
                col.innerHTML = `
                    <div style="border: 1px solid #ddd; border-radius: 8px; padding: 8px; background: white;">
                        <img src="${e.target.result}" alt="${file.name}" style="width: 100%; height: 100px; object-fit: cover; border-radius: 4px;">
                        <div style="margin-top: 8px; font-size: 12px; color: #666;">${file.name}</div>
                    </div>
                `;
                galleryGrid.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    } else {
        galleryPreview.style.display = 'none';
    }
}

// Notification Functions
function showColorSyncNotification(message, type) {
    const notification = document.getElementById('color-sync-notification');
    const messageSpan = document.getElementById('color-sync-message');
    if (notification && messageSpan) {
    messageSpan.textContent = message;
    notification.style.display = 'block';
        setTimeout(() => { notification.style.display = 'none'; }, 4000);
    }
}

function showSizeSyncNotification(message, type) {
    const notification = document.getElementById('size-sync-notification');
    const messageSpan = document.getElementById('size-sync-message');
    if (notification && messageSpan) {
        messageSpan.textContent = message;
        notification.style.display = 'block';
        setTimeout(() => { notification.style.display = 'none'; }, 4000);
    }
}

// Test Functions
window.testAddColor = function() {
    console.log('Testing addColor function...');
    if (typeof addColor === 'function') {
        console.log('✅ addColor function is available');
    } else {
        console.error('❌ addColor function is NOT available');
    }
};

window.testAddSize = function() {
    console.log('Testing addSize function...');
    if (typeof addSize === 'function') {
        console.log('✅ addSize function is available');
    } else {
        console.error('❌ addSize function is NOT available');
    }
};

window.logArrays = function() {
    console.log('Selected Colors:', selectedColors);
    console.log('Selected Sizes:', selectedSizes);
};

console.log('🔍 Functions loaded - addColor:', typeof addColor, 'addSize:', typeof addSize);

</script>
@endsection
