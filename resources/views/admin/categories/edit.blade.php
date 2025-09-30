@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: var(--text-primary); font-weight: var(--font-semibold);">
                ✏️ Edit Category: {{ $category->name }}
            </h2>
            <p class="text-muted mb-0">Update category information and settings</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-outline-info">
                <i class="bi bi-eye me-2"></i>View Details
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Categories
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Form Card -->
            <div class="card" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label" style="color: var(--text-secondary);">
                                    Category Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $category->name) }}"
                                       required
                                       style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);"
                                       placeholder="Enter category name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="slug" class="form-label" style="color: var(--text-secondary);">
                                    URL Slug
                                    <small class="text-muted">(auto-generated if empty)</small>
                                </label>
                                <input type="text"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       id="slug"
                                       name="slug"
                                       value="{{ old('slug', $category->slug) }}"
                                       style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);"
                                       placeholder="category-url-slug">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label" style="color: var(--text-secondary);">
                                Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="4"
                                      style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);"
                                      placeholder="Enter category description (optional)">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Parent Category & Order -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="parent_id" class="form-label" style="color: var(--text-secondary);">
                                    Parent Category
                                </label>
                                <select class="form-control @error('parent_id') is-invalid @enderror"
                                        id="parent_id"
                                        name="parent_id"
                                        style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);">
                                    <option value="">Select Parent Category (Root Category)</option>
                                    @foreach($parentCategories as $parent)
                                        <option value="{{ $parent->id }}"
                                                {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($category->children()->count() > 0)
                                    <small class="form-text text-warning">
                                        <i class="bi bi-exclamation-triangle"></i>
                                        This category has {{ $category->children()->count() }} child categories
                                    </small>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="order" class="form-label" style="color: var(--text-secondary);">
                                    Display Order
                                </label>
                                <input type="number"
                                       class="form-control @error('order') is-invalid @enderror"
                                       id="order"
                                       name="order"
                                       value="{{ old('order', $category->order) }}"
                                       min="0"
                                       style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);"
                                       placeholder="0">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Lower numbers appear first</small>
                            </div>
                        </div>

                        <!-- Current Image Display -->
                        @if($category->image)
                            <div class="mb-4">
                                <label class="form-label" style="color: var(--text-secondary);">Current Image</label>
                                <div class="current-image-container">
                                    <img src="{{ asset('storage/' . $category->image) }}"
                                         alt="{{ $category->name }}"
                                         class="img-thumbnail"
                                         style="max-width: 200px; max-height: 200px;">
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-outline-danger" id="remove-current-image">
                                            <i class="bi bi-trash"></i> Remove Current Image
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Image Upload -->
                        <div class="mb-4">
                            <label for="image" class="form-label" style="color: var(--text-secondary);">
                                {{ $category->image ? 'Replace Image' : 'Category Image' }}
                            </label>
                            <div class="image-upload-container">
                                <input type="file"
                                       class="form-control @error('image') is-invalid @enderror"
                                       id="image"
                                       name="image"
                                       accept="image/*"
                                       style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB</small>

                                <!-- Image Preview -->
                                <div id="image-preview" class="mt-3" style="display: none;">
                                    <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                    <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="remove-image">
                                        <i class="bi bi-trash"></i> Remove New Image
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="is_active"
                                       name="is_active"
                                       value="1"
                                       {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active" style="color: var(--text-secondary);">
                                    Active Category
                                </label>
                            </div>
                            <small class="form-text text-muted">Inactive categories won't be visible to customers</small>
                            @if($category->products()->count() > 0)
                                <small class="form-text text-info">
                                    <i class="bi bi-info-circle"></i>
                                    This category has {{ $category->products()->count() }} associated products
                                </small>
                            @endif
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                            <div>
                                <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-outline-info me-2">
                                    <i class="bi bi-eye me-2"></i>View Details
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Update Category
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Category Stats -->
            <div class="card mb-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <div class="card-header" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%); border-bottom: 1px solid var(--border-color); position: relative; overflow: hidden;">
                    <h5 class="mb-0 eye-catching-title" style="
                        background: linear-gradient(135deg, #60a5fa 0%, #34d399 50%, #fbbf24 100%);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;
                        background-clip: text;
                        font-weight: 700;
                        font-size: 1.25rem;
                        text-shadow: 0 0 20px rgba(96, 165, 250, 0.5);
                        position: relative;
                        z-index: 2;
                    ">
                        <i class="bi bi-bar-chart me-2" style="color: #60a5fa; filter: drop-shadow(0 0 8px rgba(96, 165, 250, 0.6));"></i>Category Statistics
                    </h5>
                    <div style="
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        background: linear-gradient(45deg, rgba(96, 165, 250, 0.1) 0%, rgba(52, 211, 153, 0.1) 50%, rgba(251, 191, 36, 0.1) 100%);
                        z-index: 1;
                    "></div>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="stat-item">
                                <div class="stat-number h4 mb-1" style="color: #ffffff !important; font-weight: 700; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">
                                    {{ $category->products()->count() }}
                                </div>
                                <div class="stat-label small" style="color: #ffffff !important; opacity: 0.9; font-weight: 500;">Products</div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="stat-item">
                                <div class="stat-number h4 mb-1" style="color: #ffffff !important; font-weight: 700; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">
                                    {{ $category->children()->count() }}
                                </div>
                                <div class="stat-label small" style="color: #ffffff !important; opacity: 0.9; font-weight: 500;">Sub-categories</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item">
                                <div class="stat-number h4 mb-1" style="color: #ffffff !important; font-weight: 700; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">
                                    {{ $category->contacts()->count() }}
                                </div>
                                <div class="stat-label small" style="color: #ffffff !important; opacity: 0.9; font-weight: 500;">Contacts</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item">
                                <div class="stat-number h4 mb-1" style="color: #ffffff !important; font-weight: 700; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">
                                    {{ $category->order }}
                                </div>
                                <div class="stat-label small" style="color: #ffffff !important; opacity: 0.9; font-weight: 500;">Display Order</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mb-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <div class="card-header" style="background: var(--bg-secondary); border-bottom: 1px solid var(--border-color);">
                    <h5 class="mb-0" style="color: var(--text-primary);">
                        <i class="bi bi-lightning me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.categories.contacts', $category) }}" class="btn btn-outline-info btn-sm">
                            <i class="bi bi-envelope me-2"></i>Manage Contacts ({{ $category->contacts()->count() }})
                        </a>
                        @if($category->products()->count() > 0)
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-box me-2"></i>View Products ({{ $category->products()->count() }})
                            </a>
                        @endif
                        @if($category->children()->count() > 0)
                            <a href="{{ route('admin.categories.index', ['parent_id' => $category->id]) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-folder me-2"></i>View Sub-categories ({{ $category->children()->count() }})
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Category Hierarchy -->
            @if($category->parent || $category->children()->count() > 0)
                <div class="card" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                    <div class="card-header" style="background: var(--bg-secondary); border-bottom: 1px solid var(--border-color);">
                        <h5 class="mb-0" style="color: var(--text-primary);">
                            <i class="bi bi-diagram-3 me-2"></i>Category Hierarchy
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($category->parent)
                            <div class="mb-3">
                                <small class="text-muted">Parent Category:</small>
                                <div>
                                    <a href="{{ route('admin.categories.edit', $category->parent) }}"
                                       class="text-decoration-none" style="color: var(--primary-color);">
                                        <i class="bi bi-folder-fill me-1"></i>{{ $category->parent->name }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($category->children()->count() > 0)
                            <div>
                                <small class="text-muted">Sub-categories:</small>
                                <ul class="list-unstyled mt-2">
                                    @foreach($category->children()->take(5) as $child)
                                        <li class="mb-1">
                                            <a href="{{ route('admin.categories.edit', $child) }}"
                                               class="text-decoration-none small" style="color: var(--text-secondary);">
                                                <i class="bi bi-folder me-1"></i>{{ $child->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                    @if($category->children()->count() > 5)
                                        <li class="small text-muted">
                                            ... and {{ $category->children()->count() - 5 }} more
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from name (only if slug is empty or matches the current slug pattern)
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    const originalSlug = slugInput.value;

    nameInput.addEventListener('input', function() {
        if (!slugInput.dataset.manuallyEdited) {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            slugInput.value = slug;
        }
    });

    slugInput.addEventListener('input', function() {
        if (this.value !== originalSlug) {
            this.dataset.manuallyEdited = 'true';
        }
    });

    // Image preview functionality
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const removeImageBtn = document.getElementById('remove-image');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file size (2MB = 2 * 1024 * 1024 bytes)
            if (file.size > 2 * 1024 * 1024) {
                showToast('File size must be less than 2MB', 'error');
                this.value = '';
                return;
            }

            // Validate file type
            if (!file.type.startsWith('image/')) {
                showToast('Please select a valid image file', 'error');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    if (removeImageBtn) {
        removeImageBtn.addEventListener('click', function() {
            imageInput.value = '';
            imagePreview.style.display = 'none';
            previewImg.src = '';
        });
    }

    // Remove current image functionality
    const removeCurrentImageBtn = document.getElementById('remove-current-image');
    if (removeCurrentImageBtn) {
        removeCurrentImageBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to remove the current image?')) {
                const currentImageContainer = document.querySelector('.current-image-container');
                currentImageContainer.style.display = 'none';

                // Add a hidden input to indicate image removal
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'remove_image';
                hiddenInput.value = '1';
                document.querySelector('form').appendChild(hiddenInput);

                showToast('Current image will be removed when you save the category', 'info');
            }
        });
    }
});

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'error' ? 'danger' : type} position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 5000);
}
</script>
@endpush

@push('styles')
<style>
    /* Force white placeholder text for all form controls */
    .form-control {
        background: linear-gradient(135deg, #334155 0%, #475569 100%) !important;
        border: 1px solid #64748b !important;
        color: #ffffff !important;
        border-radius: 8px !important;
    }

    .form-control:focus {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%) !important;
        border: 2px solid #3b82f6 !important;
        color: #ffffff !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3) !important;
    }

    .form-control::placeholder {
        color: #ffffff !important;
        opacity: 0.8 !important;
    }

    .form-control::-webkit-input-placeholder {
        color: #ffffff !important;
        opacity: 0.8 !important;
    }

    .form-control::-moz-placeholder {
        color: #ffffff !important;
        opacity: 0.8 !important;
    }

    .form-control:-ms-input-placeholder {
        color: #ffffff !important;
        opacity: 0.8 !important;
    }

    .form-control:-moz-placeholder {
        color: #ffffff !important;
        opacity: 0.8 !important;
    }

    /* Form labels to white */
    .form-label {
        color: #ffffff !important;
        font-weight: 600 !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    /* Textarea specific styling */
    textarea.form-control {
        background: linear-gradient(135deg, #334155 0%, #475569 100%) !important;
        color: #ffffff !important;
    }

    textarea.form-control::placeholder {
        color: #ffffff !important;
        opacity: 0.8 !important;
    }

    /* Select styling */
    select.form-control {
        background: linear-gradient(135deg, #334155 0%, #475569 100%) !important;
        color: #ffffff !important;
    }

    select.form-control option {
        background: #334155 !important;
        color: #ffffff !important;
    }

    .image-upload-container {
        border: 2px dashed #64748b;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: border-color 0.3s ease;
        background: rgba(51, 65, 85, 0.3);
    }

    .image-upload-container:hover {
        border-color: #3b82f6;
    }

    .current-image-container {
        padding: 15px;
        border: 1px solid #64748b;
        border-radius: 8px;
        background: rgba(51, 65, 85, 0.3);
    }

    .stat-item {
        padding: 10px;
        border-radius: 8px;
        background: var(--bg-tertiary);
    }

    .form-check-input:checked {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }

    .form-check-label {
        color: #ffffff !important;
        font-weight: 500;
    }

    .card-header {
        font-weight: var(--font-semibold);
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-outline-secondary:hover {
        background-color: var(--bg-tertiary);
        border-color: var(--border-color);
        color: var(--text-primary);
    }

    .btn-outline-info:hover {
        background-color: var(--info-color);
        border-color: var(--info-color);
    }

    /* Eye-catching Category Statistics Title Animation */
    .eye-catching-title {
        animation: shimmer 3s ease-in-out infinite alternate;
        transition: all 0.3s ease;
    }

    .eye-catching-title:hover {
        transform: scale(1.05);
        filter: brightness(1.2);
    }

    @keyframes shimmer {
        0% {
            background: linear-gradient(135deg, #60a5fa 0%, #34d399 50%, #fbbf24 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        50% {
            background: linear-gradient(135deg, #fbbf24 0%, #60a5fa 50%, #34d399 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        100% {
            background: linear-gradient(135deg, #34d399 0%, #fbbf24 50%, #60a5fa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    }

    /* Enhanced card header with glow effect */
    .card-header:has(.eye-catching-title) {
        box-shadow: 0 4px 15px rgba(96, 165, 250, 0.2);
        border-radius: 8px 8px 0 0;
    }

    .card-header:has(.eye-catching-title):hover {
        box-shadow: 0 6px 25px rgba(96, 165, 250, 0.4);
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }

    /* Icon glow animation */
    .bi-bar-chart {
        animation: iconGlow 2s ease-in-out infinite alternate;
    }

    @keyframes iconGlow {
        0% {
            filter: drop-shadow(0 0 8px rgba(96, 165, 250, 0.6));
        }
        100% {
            filter: drop-shadow(0 0 15px rgba(96, 165, 250, 1)) drop-shadow(0 0 25px rgba(52, 211, 153, 0.5));
        }
    }
</style>
@endpush --}}
@endsection
