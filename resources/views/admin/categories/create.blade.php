@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                ➕ Create New Category
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">Add a new category to organize your products</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary"
           style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
           onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
            <i class="bi bi-arrow-left me-2"></i>Back to Categories
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Main Form Card -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-body" style="padding: 2rem !important;">
                    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Basic Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                    Category Name <span style="color: #e53e3e !important;">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       required
                                       style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                       placeholder="Enter category name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="slug" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                    URL Slug
                                    <small style="color: #718096 !important; font-weight: 400 !important; font-size: 12px !important;">(auto-generated if empty)</small>
                                </label>
                                <input type="text"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       id="slug"
                                       name="slug"
                                       value="{{ old('slug') }}"
                                       style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                       placeholder="category-url-slug">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="4"
                                      style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; line-height: 1.6 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important; min-height: 120px !important; resize: vertical !important;"
                                      placeholder="Enter category description (optional)">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Parent Category & Order -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="parent_id" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                    Parent Category
                                </label>
                                <select class="form-control @error('parent_id') is-invalid @enderror"
                                        id="parent_id"
                                        name="parent_id"
                                        style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                                    <option value="">Select Parent Category (Root Category)</option>
                                    @foreach($parentCategories as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="order" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                    Display Order
                                </label>
                                <input type="number"
                                       class="form-control @error('order') is-invalid @enderror"
                                       id="order"
                                       name="order"
                                       value="{{ old('order', 0) }}"
                                       min="0"
                                       style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                       placeholder="0">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text" style="color: #718096 !important; font-size: 12px !important; margin-top: 6px !important;">Lower numbers appear first</small>
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-4">
                            <label for="image" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Category Image
                            </label>
                            <div class="image-upload-container">
                                <input type="file"
                                       class="form-control @error('image') is-invalid @enderror"
                                       id="image"
                                       name="image"
                                       accept="image/*"
                                       style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text" style="color: #718096 !important; font-size: 12px !important; margin-top: 6px !important;">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB</small>

                                <!-- Image Preview -->
                                <div id="image-preview" class="mt-3" style="display: none;">
                                    <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                    <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="remove-image">
                                        <i class="bi bi-trash"></i> Remove Image
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
                                       style="width: 20px !important; height: 20px !important; border: 2px solid #e2e8f0 !important; border-radius: 4px !important; background-color: #ffffff !important; transition: all 0.2s ease !important;"
                                       {{ old('is_active', 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-left: 10px !important;">
                                    Active Category
                                </label>
                            </div>
                            <small class="form-text" style="color: #718096 !important; font-size: 12px !important; margin-top: 6px !important;">Inactive categories won't be visible to customers</small>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between align-items-center" style="margin-top: 2rem !important; padding-top: 1.5rem !important; border-top: 1px solid #f7fafc !important;">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary"
                               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 14px 24px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                            <div class="d-flex gap-2">
                                <button type="submit" name="action" value="save_and_new" class="btn btn-outline-primary"
                                        style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 14px 24px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important;"
                                        onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.25) !important';"
                                        onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                    <i class="bi bi-plus-circle me-2"></i>Save & Create Another
                                </button>
                                <button type="submit" name="action" value="save" class="btn btn-primary"
                                        style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: 2px solid #3182ce !important; color: #ffffff !important; padding: 14px 24px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; box-shadow: 0 2px 4px rgba(49, 130, 206, 0.2) !important; transition: all 0.2s ease !important;"
                                        onmouseover="this.style.background='linear-gradient(135deg, #2c5aa0 0%, #2a4a8a 100%) !important'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
                                        onmouseout="this.style.background='linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(49, 130, 206, 0.2) !important';">
                                    <i class="bi bi-check-circle me-2"></i>Create Category
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
