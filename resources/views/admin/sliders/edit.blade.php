@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                ✏️ Edit Slider
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                Slider #{{ $slider->id }} • Order: {{ $slider->order }} • Status: {{ $slider->status }}
            </p>
        </div>
        <a href="{{ route('admin.sliders.show', $slider) }}" class="btn btn-outline-secondary" 
           style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
           onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
            <i class="bi bi-arrow-left me-2"></i>Back to Slider
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Slider Edit Form -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-pencil me-2" style="color: #3182ce !important;"></i>Edit Slider Details
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <form method="POST" action="{{ route('admin.sliders.update', $slider) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Slider Type -->
                        <div class="mb-4">
                            <label for="type" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Slider Type <span style="color: #e53e3e !important;">*</span>
                            </label>
                            <select class="form-control @error('type') is-invalid @enderror" 
                                    id="type" 
                                    name="type"
                                    required
                                    style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;">
                                <option value="">Select slider type...</option>
                                <option value="hero" {{ old('type', $slider->type) == 'hero' ? 'selected' : '' }}>🎯 Hero Slider (Homepage Main Slider)</option>
                                <option value="brand" {{ old('type', $slider->type) == 'brand' ? 'selected' : '' }}>🏢 Brand/Logo Carousel (Bottom Section)</option>
                                <option value="banner" {{ old('type', $slider->type) == 'banner' ? 'selected' : '' }}>📢 Banner Slider</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted mt-1 d-block">
                                <i class="bi bi-info-circle"></i> 
                                Choose where this slider will appear on the website
                            </small>
                        </div>

                        <!-- Basic Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="title" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        Title <small style="color: #718096 !important; font-weight: 400 !important;">(optional for brands)</small>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title', $slider->title) }}"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                           placeholder="Enter slider title">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="subtitle" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        Subtitle <small style="color: #718096 !important; font-weight: 400 !important;">(optional)</small>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('subtitle') is-invalid @enderror" 
                                           id="subtitle" 
                                           name="subtitle" 
                                           value="{{ old('subtitle', $slider->subtitle) }}"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                           placeholder="Enter slider subtitle">
                                    @error('subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-4">
                            <label for="image" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Slider Image <small style="color: #718096 !important; font-weight: 400 !important;">(leave empty to keep current)</small>
                            </label>
                            
                            @if($slider->image)
                                <div class="current-image mb-3" style="padding: 1rem; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 10px; border: 1px solid #e2e8f0;">
                                    <small style="color: #4a5568; font-weight: 600; margin-bottom: 8px; display: block;">Current Image:</small>
                                    <img src="{{ $slider->image_url }}" alt="Current slider image" style="max-width: 200px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                                </div>
                            @endif
                            
                            <input type="file" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*"
                                   style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text" style="color: #718096 !important; font-size: 12px !important; margin-top: 6px !important;">
                                Recommended size: 1920x600px. Supported formats: JPEG, PNG, JPG, GIF, WebP (max 2MB)
                            </small>
                        </div>

                        <!-- Link and Button -->
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label for="link" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        Link URL <small style="color: #718096 !important; font-weight: 400 !important;">(optional)</small>
                                    </label>
                                    <input type="url" 
                                           class="form-control @error('link') is-invalid @enderror" 
                                           id="link" 
                                           name="link" 
                                           value="{{ old('link', $slider->link) }}"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                           placeholder="https://example.com/target-page">
                                    @error('link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="button_text" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        Button Text <small style="color: #718096 !important; font-weight: 400 !important;">(optional)</small>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('button_text') is-invalid @enderror" 
                                           id="button_text" 
                                           name="button_text" 
                                           value="{{ old('button_text', $slider->button_text) }}"
                                           maxlength="50"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                           placeholder="Shop Now">
                                    @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Settings -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="order" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        Display Order
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('order') is-invalid @enderror" 
                                           id="order" 
                                           name="order" 
                                           value="{{ old('order', $slider->order) }}"
                                           min="0"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                           placeholder="0">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="start_date" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        Start Date <small style="color: #718096 !important; font-weight: 400 !important;">(optional)</small>
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('start_date') is-invalid @enderror" 
                                           id="start_date" 
                                           name="start_date" 
                                           value="{{ old('start_date', $slider->start_date?->format('Y-m-d')) }}"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="end_date" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        End Date <small style="color: #718096 !important; font-weight: 400 !important;">(optional)</small>
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('end_date') is-invalid @enderror" 
                                           id="end_date" 
                                           name="end_date" 
                                           value="{{ old('end_date', $slider->end_date?->format('Y-m-d')) }}"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <div class="form-check" style="padding: 1rem; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-radius: 10px; border: 1px solid #e0f2fe;">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $slider->is_active) ? 'checked' : '' }} style="margin-top: 4px;">
                                <label class="form-check-label" for="is_active" style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-left: 8px;">
                                    <i class="bi bi-toggle-on me-2" style="color: #10b981;"></i>Slider is active
                                </label>
                                <div style="color: #4a5568 !important; font-size: 12px !important; margin-left: 28px; margin-top: 4px;">
                                    Active sliders will be displayed on the website (subject to date range settings).
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.sliders.show', $slider) }}" class="btn btn-outline-secondary" 
                               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 14px 24px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary" 
                                    style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: 2px solid #3182ce !important; color: #ffffff !important; padding: 14px 24px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; box-shadow: 0 2px 4px rgba(49, 130, 206, 0.2) !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.background='linear-gradient(135deg, #2c5aa0 0%, #2a4a8a 100%) !important'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
                                    onmouseout="this.style.background='linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(49, 130, 206, 0.2) !important';">
                                <i class="bi bi-check-circle me-2"></i>Update Slider
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Current Slider Preview -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-eye me-2" style="color: #3182ce !important;"></i>Current Slider
                    </h5>
                </div>
                <div class="card-body" style="padding: 0 !important;">
                    <div class="slider-preview">
                        <!-- Current Image -->
                        @if($slider->image)
                            <div class="slider-image" style="height: 150px; overflow: hidden; position: relative;">
                                <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge" style="background: {{ $slider->status_color }} !important; color: #ffffff !important; font-size: 10px !important; padding: 4px 8px !important; border-radius: 12px !important;">
                                        {{ $slider->status }}
                                    </span>
                                </div>
                            </div>
                        @endif
                        
                        <div style="padding: 1.5rem !important;">
                            @if($slider->title)
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 8px !important;">{{ $slider->title }}</h6>
                            @endif
                            @if($slider->subtitle)
                                <p style="color: #4a5568 !important; font-size: 14px !important; margin-bottom: 12px !important;">{{ $slider->subtitle }}</p>
                            @endif
                            @if($slider->button_text)
                                <div class="btn btn-primary btn-sm" style="background: #3182ce !important; border: none !important; color: #ffffff !important; padding: 6px 12px !important; border-radius: 6px !important; font-size: 12px !important; pointer-events: none;">
                                    {{ $slider->button_text }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slider Statistics -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-graph-up me-2" style="color: #3182ce !important;"></i>Slider Details
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="slider-stats">
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Slider ID</span>
                                <span style="color: #3182ce !important; font-weight: 700 !important; font-size: 14px !important;">#{{ $slider->id }}</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Status</span>
                                <span style="color: {{ $slider->status_color }} !important; font-weight: 700 !important; font-size: 14px !important;">{{ $slider->status }}</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Duration</span>
                                <span style="color: #f59e0b !important; font-weight: 700 !important; font-size: 14px !important;">{{ $slider->duration }}</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border-radius: 8px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Order</span>
                                <span style="color: #8b5cf6 !important; font-weight: 700 !important; font-size: 14px !important;">{{ $slider->order }}</span>
                            </div>
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
    // Date validation
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    function validateDates() {
        if (startDateInput.value && endDateInput.value) {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            
            if (endDate < startDate) {
                endDateInput.style.borderColor = '#ef4444';
                endDateInput.style.boxShadow = '0 0 0 2px rgba(239, 68, 68, 0.2)';
            } else {
                endDateInput.style.borderColor = '#e2e8f0';
                endDateInput.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
            }
        }
    }
    
    startDateInput.addEventListener('change', validateDates);
    endDateInput.addEventListener('change', validateDates);
    
    // Image preview functionality
    const imageInput = document.getElementById('image');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Could add image preview here if needed
                    console.log('New image selected:', file.name);
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endpush

@push('styles')
<style>
    /* CLEAN SLIDERS EDIT PAGE - Professional Styling */
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
    
    .current-image img {
        transition: all 0.2s ease !important;
    }
    
    .current-image img:hover {
        transform: scale(1.05) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }
    
    .slider-preview img {
        transition: all 0.2s ease !important;
    }
    
    .stat-item {
        transition: all 0.2s ease !important;
    }
    
    .stat-item:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endpush
@endsection
