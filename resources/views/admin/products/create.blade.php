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
                        
                        <!-- Basic Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Product Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}">
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Category and Brand -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category *</label>
                                    <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="brand_id" class="form-label">Brand</label>
                                    <select class="form-control @error('brand_id') is-invalid @enderror" id="brand_id" name="brand_id">
                                        <option value="">Select Brand</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Price and Stock -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price *</label>
                                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="sale_price" class="form-label">Sale Price</label>
                                    <input type="number" step="0.01" class="form-control @error('sale_price') is-invalid @enderror" id="sale_price" name="sale_price" value="{{ old('sale_price') }}">
                                    @error('sale_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="mt-2">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stock</label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', 0) }}">
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Primary Image -->
                        <div class="mb-4">
                            <label for="image" class="form-label">Primary Image *</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" required>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Simple Gallery Images -->
                        <div class="mb-4">
                            <label class="form-label">Gallery Images</label>
                            <input type="file" id="gallery-images" name="gallery_images[]" accept="image/*" multiple class="form-control @error('gallery_images') is-invalid @enderror">
                            <small class="form-text text-muted">Select multiple images for the gallery (JPG, PNG, WebP - max 5MB each)</small>
                            @error('gallery_images')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Simple Gallery Preview -->
                        <div id="gallery-preview" style="display: none; border: 1px solid #ddd; padding: 1rem; border-radius: 8px; background: #f8f9fa; margin-top: 1rem;">
                            <h6>Gallery Preview (<span id="gallery-count">0</span> images)</h6>
                            <div id="gallery-grid" class="row g-2"></div>
                        </div>
                        
                        <!-- Color Management Section -->
                        <div class="mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">🎨 Color Management</h5>
                                    <small class="text-muted">Add colors for this product. These will appear as color dots on the frontend.</small>
                                </div>
                                <div class="card-body">
                                    <!-- Color Input Section -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="color_name" class="form-label">Color Name</label>
                                            <input type="text" class="form-control" id="color_name" placeholder="e.g., Navy Blue, Forest Green">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="color_hex" class="form-label">Color Code</label>
                                            <input type="color" class="form-control" id="color_hex" value="#000000">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="color_stock" class="form-label">Stock</label>
                                            <input type="number" class="form-control" id="color_stock" placeholder="Quantity" min="0">
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
                                    
                                    <!-- Quick Color Presets -->
                                    <div class="mt-3">
                                        <h6>Quick Color Presets:</h6>
                                        <div class="d-flex flex-wrap gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetColor('Black', '#000000')">Black</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetColor('White', '#ffffff')">White</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetColor('Red', '#ff0000')">Red</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetColor('Blue', '#0000ff')">Blue</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetColor('Green', '#00ff00')">Green</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetColor('Yellow', '#ffff00')">Yellow</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetColor('Pink', '#ffc0cb')">Pink</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetColor('Gray', '#808080')">Gray</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetColor('Brown', '#a52a2a')">Brown</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetColor('Navy', '#000080')">Navy</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Size Management Section -->
                        <div class="mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">📏 Size Management</h5>
                                    <small class="text-muted">Add sizes for this product. These will appear as size buttons on the frontend.</small>
                                </div>
                                <div class="card-body">
                                    <!-- Size Input Section -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="size_name" class="form-label">Size Name</label>
                                            <input type="text" class="form-control" id="size_name" placeholder="e.g., Small, Medium, Large, XL">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="size_stock" class="form-label">Stock</label>
                                            <input type="number" class="form-control" id="size_stock" placeholder="Quantity" min="0">
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
                                    
                                    <!-- Quick Size Presets -->
                                    <div class="mt-3">
                                        <h6>Quick Size Presets:</h6>
                                        <div class="d-flex flex-wrap gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetSize('XS', 'Chest: 32-34 inches')">XS</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetSize('S', 'Chest: 34-36 inches')">S</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetSize('M', 'Chest: 36-38 inches')">M</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetSize('L', 'Chest: 38-40 inches')">L</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetSize('XL', 'Chest: 40-42 inches')">XL</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetSize('XXL', 'Chest: 42-44 inches')">XXL</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetSize('28', 'Waist: 28 inches')">28</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetSize('30', 'Waist: 30 inches')">30</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetSize('32', 'Waist: 32 inches')">32</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPresetSize('34', 'Waist: 34 inches')">34</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status') ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">
                                    Active
                                </label>
                            </div>
                        </div>

                        <!-- Countdown Timer Settings -->
                        <div class="mb-4">
                            <label class="form-label">Countdown Timer Settings</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="enable_countdown" name="enable_countdown" value="1" {{ old('enable_countdown') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="enable_countdown">
                                            Enable Countdown Timer
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="countdown_date" class="form-label">Countdown End Date</label>
                                    <input type="datetime-local" class="form-control @error('countdown_date') is-invalid @enderror" id="countdown_date" name="countdown_date" value="{{ old('countdown_date') }}">
                                    @error('countdown_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <small class="form-text text-muted">Set when the countdown timer should expire. Multiple products can share the same countdown date.</small>
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setCommonCountdown()">
                                    <i class="ti-calendar"></i> Set Common Sale End Date
                                </button>
                                <small class="text-muted ms-2">Quick set for seasonal sales</small>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary" id="create-product-btn">Create Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
    const colorStock = document.getElementById('color_stock').value || 0;
    
    if (!colorName) {
        alert('Please enter a color name');
        return;
    }
    
    // Check if color already exists
    if (selectedColors.some(color => color.name.toLowerCase() === colorName.toLowerCase())) {
        alert('This color has already been added');
        return;
    }
    
    // Add color to array
    const newColor = {
        name: colorName,
        hex: colorHex,
        stock: parseInt(colorStock)
    };
    
    selectedColors.push(newColor);
    
    // Clear inputs
    document.getElementById('color_name').value = '';
    document.getElementById('color_hex').value = '#000000';
    document.getElementById('color_stock').value = '';
    
    // Update preview
    updateColorsPreview();
    
    console.log('Color added:', newColor);
}

function addPresetColor(name, hex) {
    document.getElementById('color_name').value = name;
    document.getElementById('color_hex').value = hex;
    document.getElementById('color_stock').value = 10; // Default stock
    addColor();
}

function removeColor(index) {
    selectedColors.splice(index, 1);
    updateColorsPreview();
    console.log('Color removed at index:', index);
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
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeColor(${index})">
                <i class="fas fa-times"></i>
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
}

// Size Management Functions
function addSize() {
    const sizeName = document.getElementById('size_name').value.trim();
    const sizeStock = document.getElementById('size_stock').value || 0;
    const sizeGuide = document.getElementById('size_guide').value.trim();
    
    if (!sizeName) {
        alert('Please enter a size name');
        return;
    }
    
    // Check if size already exists
    if (selectedSizes.some(size => size.name.toLowerCase() === sizeName.toLowerCase())) {
        alert('This size has already been added');
        return;
    }
    
    // Add size to array
    const newSize = {
        name: sizeName,
        stock: parseInt(sizeStock),
        guide: sizeGuide
    };
    
    selectedSizes.push(newSize);
    
    // Clear inputs
    document.getElementById('size_name').value = '';
    document.getElementById('size_stock').value = '';
    document.getElementById('size_guide').value = '';
    
    // Update preview
    updateSizesPreview();
    
    console.log('Size added:', newSize);
}

function addPresetSize(name, guide) {
    document.getElementById('size_name').value = name;
    document.getElementById('size_guide').value = guide;
    document.getElementById('size_stock').value = 10; // Default stock
    addSize();
}

function removeSize(index) {
    selectedSizes.splice(index, 1);
    updateSizesPreview();
    console.log('Size removed at index:', index);
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
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSize(${index})">
                <i class="fas fa-times"></i>
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
}

// Initialize color and size management
document.addEventListener('DOMContentLoaded', function() {
    updateColorsPreview();
    updateSizesPreview();
});
</script>
@endsection
        