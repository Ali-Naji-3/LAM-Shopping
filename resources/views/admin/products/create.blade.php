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
</script>
@endsection
