@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                ➕ Create New Attribute
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">Add a new product attribute to organize product properties</p>
        </div>
        <a href="{{ route('admin.attributes.index') }}" class="btn btn-outline-secondary" 
           style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
           onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
            <i class="bi bi-arrow-left me-2"></i>Back to Attributes
        </a>
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
                    <form method="POST" action="{{ route('admin.attributes.store') }}">
                        @csrf
                        
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
                                       value="{{ old('name') }}" 
                                       required
                                       style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                       placeholder="Enter attribute name (e.g., Size, Color, Material)">
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
                                    <div class="form-check attribute-type-option" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; padding: 1.5rem !important; border-radius: 12px !important; border: 2px solid #e0f2fe !important; transition: all 0.2s ease !important; cursor: pointer !important;"
                                         onclick="selectAttributeType('text', this)">
                                        <input class="form-check-input" type="radio" name="type" id="type_text" value="text" {{ old('type', 'select') === 'text' ? 'checked' : '' }} required>
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
                                    <div class="form-check attribute-type-option" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important; padding: 1.5rem !important; border-radius: 12px !important; border: 2px solid #d1fae5 !important; transition: all 0.2s ease !important; cursor: pointer !important;"
                                         onclick="selectAttributeType('select', this)">
                                        <input class="form-check-input" type="radio" name="type" id="type_select" value="select" {{ old('type', 'select') === 'select' ? 'checked' : '' }} required>
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
                                    <div class="form-check attribute-type-option" style="background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; padding: 1.5rem !important; border-radius: 12px !important; border: 2px solid #fed7aa !important; transition: all 0.2s ease !important; cursor: pointer !important;"
                                         onclick="selectAttributeType('checkbox', this)">
                                        <input class="form-check-input" type="radio" name="type" id="type_checkbox" value="checkbox" {{ old('type') === 'checkbox' ? 'checked' : '' }} required>
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
                                    <div class="form-check attribute-type-option" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; padding: 1.5rem !important; border-radius: 12px !important; border: 2px solid #e9d5ff !important; transition: all 0.2s ease !important; cursor: pointer !important;"
                                         onclick="selectAttributeType('radio', this)">
                                        <input class="form-check-input" type="radio" name="type" id="type_radio" value="radio" {{ old('type') === 'radio' ? 'checked' : '' }} required>
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
                                       {{ old('is_required') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_required" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-left: 10px !important;">
                                    Required Attribute
                                </label>
                            </div>
                            <small class="form-text" style="color: #718096 !important; font-size: 12px !important; margin-top: 6px !important;">Required attributes must be filled when creating products</small>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between align-items-center" style="margin-top: 2rem !important; padding-top: 1.5rem !important; border-top: 1px solid #f7fafc !important;">
                            <a href="{{ route('admin.attributes.index') }}" class="btn btn-outline-secondary" 
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
                                    <i class="bi bi-check-circle me-2"></i>Create Attribute
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Attribute Types Guide Card -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-info-circle me-2" style="color: #3182ce !important;"></i>Attribute Types Guide
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="mb-4" style="padding: 1.25rem !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 10px !important; border-left: 4px solid #3182ce !important;">
                        <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 15px !important; margin-bottom: 1rem !important;">📝 Text Input</h6>
                        <ul style="margin-bottom: 0 !important; padding-left: 1.25rem !important;">
                            <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Free text entry</li>
                            <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Best for: Descriptions, Notes</li>
                            <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0 !important;">Example: Product Notes</li>
                        </ul>
                    </div>
                    
                    <div class="mb-4" style="padding: 1.25rem !important; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important; border-radius: 10px !important; border-left: 4px solid #10b981 !important;">
                        <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 15px !important; margin-bottom: 1rem !important;">📋 Dropdown Select</h6>
                        <ul style="margin-bottom: 0 !important; padding-left: 1.25rem !important;">
                            <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Choose one option</li>
                            <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Best for: Size, Color, Material</li>
                            <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0 !important;">Example: Small, Medium, Large</li>
                        </ul>
                    </div>
                    
                    <div class="mb-4" style="padding: 1.25rem !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 10px !important; border-left: 4px solid #f59e0b !important;">
                        <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 15px !important; margin-bottom: 1rem !important;">☑️ Checkbox</h6>
                        <ul style="margin-bottom: 0 !important; padding-left: 1.25rem !important;">
                            <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Multiple selections</li>
                            <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Best for: Features, Options</li>
                            <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0 !important;">Example: WiFi, Bluetooth, GPS</li>
                        </ul>
                    </div>
                    
                    <div class="mb-3" style="padding: 1.25rem !important; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border-radius: 10px !important; border-left: 4px solid #8b5cf6 !important;">
                        <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 15px !important; margin-bottom: 1rem !important;">🔘 Radio Button</h6>
                        <ul style="margin-bottom: 0 !important; padding-left: 1.25rem !important;">
                            <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Single selection only</li>
                            <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Best for: Exclusive choices</li>
                            <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0 !important;">Example: Gender, Priority</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Contact Integration Card -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-envelope me-2" style="color: #3182ce !important;"></i>Contact Integration
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div style="padding: 1.25rem !important; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border-radius: 10px !important; border-left: 4px solid #8b5cf6 !important; margin-bottom: 1.5rem !important;">
                        <p style="color: #1a202c !important; font-size: 14px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0 !important;">
                            Each attribute can receive customer inquiries about product specifications. After creating this attribute, you can:
                        </p>
                    </div>
                    <ul style="margin-bottom: 0 !important; padding-left: 1.25rem !important;">
                        <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.75rem !important;">📧 Manage attribute-specific contacts</li>
                        <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.75rem !important;">📊 Track specification inquiries</li>
                        <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.75rem !important;">🤖 Set up automated responses</li>
                        <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0 !important;">📈 Monitor attribute analytics</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from name
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
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
        this.dataset.manuallyEdited = 'true';
    });
});

// Attribute type selection function
function selectAttributeType(type, element) {
    // Remove active state from all options
    document.querySelectorAll('.attribute-type-option').forEach(option => {
        option.style.borderColor = option.style.borderColor.replace('#3182ce', '#e0f2fe');
        option.style.boxShadow = 'none';
        option.style.transform = 'translateY(0)';
    });
    
    // Add active state to selected option
    element.style.borderColor = '#3182ce !important';
    element.style.boxShadow = '0 4px 12px rgba(49, 130, 206, 0.15) !important';
    element.style.transform = 'translateY(-2px) !important';
    
    // Check the radio button
    document.getElementById('type_' + type).checked = true;
    
    console.log('Selected attribute type:', type);
}
</script>
@endpush

@push('styles')
<style>
    /* CLEAN ATTRIBUTES CREATE PAGE - Professional Styling */
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
    
    .attribute-type-option input[type="radio"]:checked + label {
        font-weight: 700 !important;
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
</style>
@endpush
@endsection
