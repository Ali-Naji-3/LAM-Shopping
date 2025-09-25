@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                ✏️ Edit Attribute: {{ $attribute->name }}
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">Update attribute information and settings</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.attributes.show', $attribute) }}" class="btn btn-outline-info" 
               style="color: #0891b2 !important; border-color: #0891b2 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#0891b2 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#0891b2 !important';">
                <i class="bi bi-eye me-2"></i>View Attribute
            </a>
            <a href="{{ route('admin.attributes.index') }}" class="btn btn-outline-secondary" 
               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                <i class="bi bi-arrow-left me-2"></i>Back to Attributes
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Form Card -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-info-circle me-2" style="color: #3182ce !important;"></i>Attribute Information
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <form method="POST" action="{{ route('admin.attributes.update', $attribute) }}">
                        @csrf
                        @method('PUT')
                        
                        <!-- Basic Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                    Attribute Name <span style="color: #e53e3e !important;">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $attribute->name) }}" 
                                       required
                                       style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                       placeholder="Enter attribute name">
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
                                       value="{{ old('slug', $attribute->slug) }}"
                                       style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                       placeholder="attribute-url-slug">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Attribute Type -->
                        <div class="mb-4">
                            <label for="type" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 15px !important;">
                                Attribute Type <span style="color: #e53e3e !important;">*</span>
                            </label>
                            <div class="row">
                                <div class="col-md-6 col-lg-3 mb-3">
                                    <div class="form-check attribute-type-option {{ $attribute->type === 'text' ? 'selected' : '' }}" 
                                         style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; padding: 1.5rem !important; border-radius: 12px !important; border: 2px solid {{ $attribute->type === 'text' ? '#3182ce' : '#e0f2fe' }} !important; transition: all 0.2s ease !important; cursor: pointer !important;"
                                         onclick="selectAttributeType('text', this)">
                                        <input class="form-check-input" type="radio" name="type" id="type_text" value="text" {{ old('type', $attribute->type) === 'text' ? 'checked' : '' }} required>
                                        <label class="form-check-label w-100" for="type_text" style="cursor: pointer !important;">
                                            <div class="text-center">
                                                <i class="bi bi-input-cursor-text" style="color: #3182ce !important; font-size: 24px !important; margin-bottom: 8px !important; display: block !important;"></i>
                                                <strong style="color: #1a202c !important; font-size: 14px !important; display: block !important;">Text Input</strong>
                                                <small style="color: #4a5568 !important; font-size: 12px !important;">Free text entry</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3 mb-3">
                                    <div class="form-check attribute-type-option {{ $attribute->type === 'select' ? 'selected' : '' }}" 
                                         style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important; padding: 1.5rem !important; border-radius: 12px !important; border: 2px solid {{ $attribute->type === 'select' ? '#10b981' : '#d1fae5' }} !important; transition: all 0.2s ease !important; cursor: pointer !important;"
                                         onclick="selectAttributeType('select', this)">
                                        <input class="form-check-input" type="radio" name="type" id="type_select" value="select" {{ old('type', $attribute->type) === 'select' ? 'checked' : '' }} required>
                                        <label class="form-check-label w-100" for="type_select" style="cursor: pointer !important;">
                                            <div class="text-center">
                                                <i class="bi bi-list-ul" style="color: #10b981 !important; font-size: 24px !important; margin-bottom: 8px !important; display: block !important;"></i>
                                                <strong style="color: #1a202c !important; font-size: 14px !important; display: block !important;">Dropdown</strong>
                                                <small style="color: #4a5568 !important; font-size: 12px !important;">Select from options</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3 mb-3">
                                    <div class="form-check attribute-type-option {{ $attribute->type === 'checkbox' ? 'selected' : '' }}" 
                                         style="background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; padding: 1.5rem !important; border-radius: 12px !important; border: 2px solid {{ $attribute->type === 'checkbox' ? '#f59e0b' : '#fed7aa' }} !important; transition: all 0.2s ease !important; cursor: pointer !important;"
                                         onclick="selectAttributeType('checkbox', this)">
                                        <input class="form-check-input" type="radio" name="type" id="type_checkbox" value="checkbox" {{ old('type', $attribute->type) === 'checkbox' ? 'checked' : '' }} required>
                                        <label class="form-check-label w-100" for="type_checkbox" style="cursor: pointer !important;">
                                            <div class="text-center">
                                                <i class="bi bi-check-square" style="color: #f59e0b !important; font-size: 24px !important; margin-bottom: 8px !important; display: block !important;"></i>
                                                <strong style="color: #1a202c !important; font-size: 14px !important; display: block !important;">Checkbox</strong>
                                                <small style="color: #4a5568 !important; font-size: 12px !important;">Multiple choices</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3 mb-3">
                                    <div class="form-check attribute-type-option {{ $attribute->type === 'radio' ? 'selected' : '' }}" 
                                         style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; padding: 1.5rem !important; border-radius: 12px !important; border: 2px solid {{ $attribute->type === 'radio' ? '#8b5cf6' : '#e9d5ff' }} !important; transition: all 0.2s ease !important; cursor: pointer !important;"
                                         onclick="selectAttributeType('radio', this)">
                                        <input class="form-check-input" type="radio" name="type" id="type_radio" value="radio" {{ old('type', $attribute->type) === 'radio' ? 'checked' : '' }} required>
                                        <label class="form-check-label w-100" for="type_radio" style="cursor: pointer !important;">
                                            <div class="text-center">
                                                <i class="bi bi-circle" style="color: #8b5cf6 !important; font-size: 24px !important; margin-bottom: 8px !important; display: block !important;"></i>
                                                <strong style="color: #1a202c !important; font-size: 14px !important; display: block !important;">Radio Button</strong>
                                                <small style="color: #4a5568 !important; font-size: 12px !important;">Single choice</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Required Setting -->
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_required" 
                                       name="is_required" 
                                       value="1" 
                                       style="width: 20px !important; height: 20px !important; border: 2px solid #e2e8f0 !important; border-radius: 4px !important; background-color: #ffffff !important; transition: all 0.2s ease !important;"
                                       {{ old('is_required', $attribute->is_required) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_required" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-left: 10px !important;">
                                    Required Attribute
                                </label>
                            </div>
                            <small class="form-text" style="color: #718096 !important; font-size: 12px !important; margin-top: 6px !important;">Required attributes must be filled when creating products</small>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between align-items-center" style="margin-top: 2rem !important; padding-top: 1.5rem !important; border-top: 1px solid #f7fafc !important;">
                            <a href="{{ route('admin.attributes.show', $attribute) }}" class="btn btn-outline-secondary" 
                               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 14px 24px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary" 
                                    style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: 2px solid #3182ce !important; color: #ffffff !important; padding: 14px 24px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; box-shadow: 0 2px 4px rgba(49, 130, 206, 0.2) !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.background='linear-gradient(135deg, #2c5aa0 0%, #2a4a8a 100%) !important'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
                                    onmouseout="this.style.background='linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(49, 130, 206, 0.2) !important';">
                                <i class="bi bi-check-circle me-2"></i>Update Attribute
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Attribute Statistics Card -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important; position: relative !important; overflow: hidden !important;">
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
                        animation: shimmer 4s ease-in-out infinite alternate;
                        background-size: 200% 100%;
                    ">
                        <i class="bi bi-bar-chart me-2" style="color: #60a5fa; filter: drop-shadow(0 0 8px rgba(96, 165, 250, 0.6)); animation: iconGlow 3s ease-in-out infinite;"></i>Attribute Statistics
                    </h5>
                </div>
                <div class="card-body" style="background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%) !important; padding: 2rem !important; border-radius: 0 0 12px 12px !important;">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="stat-number h4 mb-1" style="color: #ffffff !important; font-weight: 700; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">
                                {{ $attribute->attributeValues()->count() }}
                            </div>
                            <div class="stat-label small" style="color: #ffffff !important; opacity: 0.9; font-weight: 500;">Values</div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="stat-number h4 mb-1" style="color: #ffffff !important; font-weight: 700; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">
                                {{ ucfirst($attribute->type) }}
                            </div>
                            <div class="stat-label small" style="color: #ffffff !important; opacity: 0.9; font-weight: 500;">Type</div>
                        </div>
                        <div class="col-6">
                            <div class="stat-number h4 mb-1" style="color: #ffffff !important; font-weight: 700; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">
                                {{ $attribute->is_required ? 'Yes' : 'No' }}
                            </div>
                            <div class="stat-label small" style="color: #ffffff !important; opacity: 0.9; font-weight: 500;">Required</div>
                        </div>
                        <div class="col-6">
                            <div class="stat-number h4 mb-1" style="color: #ffffff !important; font-weight: 700; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">
                                {{ $attribute->created_at->format('M Y') }}
                            </div>
                            <div class="stat-label small" style="color: #ffffff !important; opacity: 0.9; font-weight: 500;">Created</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Type Display Card -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-gear me-2" style="color: #3182ce !important;"></i>Current Settings
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div style="padding: 1.25rem !important; background: linear-gradient(135deg, {{ $attribute->type === 'text' ? '#f0f9ff, #e0f2fe' : ($attribute->type === 'select' ? '#ecfdf5, #d1fae5' : ($attribute->type === 'checkbox' ? '#fef3c7, #fed7aa' : '#f3e8ff, #e9d5ff')) }}) !important; border-radius: 10px !important; border-left: 4px solid {{ $attribute->type === 'text' ? '#3182ce' : ($attribute->type === 'select' ? '#10b981' : ($attribute->type === 'checkbox' ? '#f59e0b' : '#8b5cf6')) }} !important; margin-bottom: 1.5rem !important;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="type-icon" style="background: {{ $attribute->type === 'text' ? '#3182ce' : ($attribute->type === 'select' ? '#10b981' : ($attribute->type === 'checkbox' ? '#f59e0b' : '#8b5cf6')) }} !important; width: 40px !important; height: 40px !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important;">
                                <i class="bi bi-{{ $attribute->type === 'text' ? 'input-cursor-text' : ($attribute->type === 'select' ? 'list-ul' : ($attribute->type === 'checkbox' ? 'check-square' : 'circle')) }}" style="color: #ffffff !important; font-size: 16px !important;"></i>
                            </div>
                            <div>
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 4px !important;">{{ ucfirst($attribute->type) }} Attribute</h6>
                                <p style="color: #2d3748 !important; font-size: 12px !important; margin-bottom: 0 !important;">
                                    {{ $attribute->is_required ? 'Required field' : 'Optional field' }} • {{ $attribute->attributeValues()->count() }} values
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.attributes.values', $attribute) }}" class="btn btn-outline-primary"
                           style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; transition: all 0.2s ease !important; text-decoration: none !important; font-weight: 600 !important;"
                           onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                            <i class="bi bi-list me-2"></i>Manage Values ({{ $attribute->attributeValues()->count() }})
                        </a>
                        <a href="{{ route('admin.attributes.products', $attribute) }}" class="btn btn-outline-success"
                           style="color: #10b981 !important; border-color: #10b981 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; transition: all 0.2s ease !important; text-decoration: none !important; font-weight: 600 !important;"
                           onmouseover="this.style.backgroundColor='#10b981 !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#10b981 !important';">
                            <i class="bi bi-box me-2"></i>View Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from name (but preserve manual edits)
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    const originalSlug = slugInput.value;
    
    nameInput.addEventListener('input', function() {
        // Only auto-generate if slug hasn't been manually edited
        if (slugInput.value === originalSlug || !slugInput.dataset.manuallyEdited) {
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
        this.dataset.manuallyEdited = 'true';
    });
});

// Attribute type selection function
function selectAttributeType(type, element) {
    // Remove active state from all options
    document.querySelectorAll('.attribute-type-option').forEach(option => {
        option.classList.remove('selected');
        option.style.borderColor = '';
        option.style.boxShadow = 'none';
        option.style.transform = 'translateY(0)';
    });
    
    // Add active state to selected option
    element.classList.add('selected');
    element.style.borderColor = '#3182ce !important';
    element.style.boxShadow = '0 4px 12px rgba(49, 130, 206, 0.15) !important';
    element.style.transform = 'translateY(-2px) !important';
    
    // Check the radio button
    document.getElementById('type_' + type).checked = true;
    
    console.log('Selected attribute type:', type);
}

// Set initial selected state
document.addEventListener('DOMContentLoaded', function() {
    const selectedType = document.querySelector('input[name="type"]:checked');
    if (selectedType) {
        const typeValue = selectedType.value;
        const element = selectedType.closest('.attribute-type-option');
        selectAttributeType(typeValue, element);
    }
});
</script>
@endpush

@push('styles')
<style>
    /* CLEAN ATTRIBUTES EDIT PAGE - Professional Styling */
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
    
    /* Clean Placeholders */
    .form-control::placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    
    .form-control::-webkit-input-placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    
    .form-control::-moz-placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    
    .form-control:-ms-input-placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    
    .form-control:-moz-placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    
    /* Professional Attribute Type Options */
    .attribute-type-option {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .attribute-type-option:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        border-color: #3182ce !important;
    }
    
    .attribute-type-option.selected {
        border-color: #3182ce !important;
        box-shadow: 0 4px 12px rgba(49, 130, 206, 0.15) !important;
        transform: translateY(-2px) !important;
    }
    
    /* Professional Checkbox */
    .form-check-input:checked {
        background-color: #3182ce !important;
        border-color: #3182ce !important;
        box-shadow: 0 0 0 2px rgba(49, 130, 206, 0.2) !important;
    }
    
    .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.15) !important;
        border-color: #3182ce !important;
    }
    
    /* Eye-catching statistics animations */
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    
    @keyframes iconGlow {
        0%, 100% { filter: drop-shadow(0 0 8px rgba(96, 165, 250, 0.6)); }
        50% { filter: drop-shadow(0 0 15px rgba(96, 165, 250, 0.9)); }
    }
    
    .eye-catching-title {
        animation: shimmer 4s ease-in-out infinite alternate;
        background-size: 200% 100%;
    }
    
    .eye-catching-title i {
        animation: iconGlow 3s ease-in-out infinite;
    }
    
    .card-header:has(.eye-catching-title) {
        position: relative;
        overflow: hidden;
    }
    
    .card-header:has(.eye-catching-title):hover {
        box-shadow: 0 4px 20px rgba(96, 165, 250, 0.2) !important;
    }
</style>
@endpush
@endsection
