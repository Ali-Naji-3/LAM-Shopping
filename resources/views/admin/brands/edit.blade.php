@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Compact Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0" style="color: #1a202c; font-weight: 700;">🏷️ Edit Brand</h1>
                    <p style="color: #4a5568; font-size: 14px; margin-bottom: 0;">{{ $brand->name }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.brands.show', $brand) }}" class="btn btn-info" style="font-weight: 600;">
                        <i class="fas fa-eye me-1"></i> View Details
                    </a>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary" style="font-weight: 600;">
                        <i class="fas fa-arrow-left me-1"></i> Back to Brands
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Form -->
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 15px;">
                    <h6 class="m-0" style="color: #2d3748; font-weight: 700; font-size: 15px;">Edit Brand Information</h6>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-tag text-primary me-1"></i> Brand Name *
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name', $brand->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-link text-info me-1"></i> Slug *
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('slug') is-invalid @enderror" 
                                           name="slug" value="{{ old('slug', $brand->slug) }}" required>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                <i class="fas fa-align-left text-secondary me-1"></i> Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      name="description" rows="4">{{ old('description', $brand->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-image text-success me-1"></i> Brand Logo
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('image') is-invalid @enderror" 
                                           name="image" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if($brand->image)
                                        <small class="form-text text-muted">Current image will be replaced if new one is uploaded</small>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-toggle-on text-warning me-1"></i> Status *
                                    </label>
                                    <select class="form-control @error('is_active') is-invalid @enderror" name="is_active" required>
                                        <option value="1" {{ old('is_active', $brand->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active', $brand->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" style="font-weight: 600; border-radius: 8px; padding: 10px 20px;">
                                <i class="fas fa-save me-1"></i> Update Brand
                            </button>
                            <a href="{{ route('admin.brands.show', $brand) }}" class="btn btn-secondary" style="font-weight: 600; border-radius: 8px; padding: 10px 20px;">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Current Image -->
            @if($brand->image)
            <div class="card shadow border-0 mb-3" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); color: white; padding: 15px;">
                    <h6 class="m-0" style="font-weight: 700; font-size: 14px;">🖼️ Current Logo</h6>
                </div>
                <div class="card-body p-3 text-center">
                    <img src="{{ Storage::url($brand->image) }}" alt="{{ $brand->name }}" 
                         class="img-fluid rounded" style="max-width: 200px; border: 2px solid #e2e8f0;">
                </div>
            </div>
            @endif

            <!-- Brand Guidelines -->
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%); color: white; padding: 15px;">
                    <h6 class="m-0" style="font-weight: 700; font-size: 14px;">📋 Brand Guidelines</h6>
                </div>
                <div class="card-body p-3">
                    <div style="color: #2d3748; font-size: 12px; line-height: 1.5;">
                        <p class="mb-2"><strong>📝 Naming Tips:</strong></p>
                        <ul class="mb-3" style="padding-left: 16px;">
                            <li>Use official brand names</li>
                            <li>Maintain consistent capitalization</li>
                            <li>Keep names concise but recognizable</li>
                        </ul>
                        
                        <p class="mb-2"><strong>🖼️ Logo Guidelines:</strong></p>
                        <ul class="mb-0" style="padding-left: 16px;">
                            <li>Recommended size: 300x300px</li>
                            <li>Use high-quality images</li>
                            <li>Transparent background preferred</li>
                            <li>Consistent style across brands</li>
                        </ul>
                    </div>
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

.stat-item {
    transition: all 0.3s ease !important;
}

.stat-item:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
}
</style>
@endpush
@endsection
