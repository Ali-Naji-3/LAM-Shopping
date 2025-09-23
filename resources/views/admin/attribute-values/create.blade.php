@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                ➕ Create Attribute Value
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">Add a new value for product attributes</p>
        </div>
        <a href="{{ route('admin.attributeValues.index') }}" class="btn btn-outline-secondary" 
           style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
           onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
            <i class="bi bi-arrow-left me-2"></i>Back to Values
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Single Value Creation -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-plus-circle me-2" style="color: #3182ce !important;"></i>Add Single Value
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <form method="POST" action="{{ route('admin.attributeValues.store') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="attribute_id" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Select Attribute <span style="color: #e53e3e !important;">*</span>
                            </label>
                            <select class="form-control @error('attribute_id') is-invalid @enderror" 
                                    id="attribute_id" 
                                    name="attribute_id" 
                                    required
                                    style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                    onchange="updateAttributePreview(this)">
                                <option value="">Choose an attribute...</option>
                                @foreach($attributes as $attribute)
                                    <option value="{{ $attribute->id }}" 
                                            data-type="{{ $attribute->type }}" 
                                            data-name="{{ $attribute->name }}"
                                            {{ old('attribute_id') == $attribute->id ? 'selected' : '' }}>
                                        {{ $attribute->name }} ({{ ucfirst($attribute->type) }})
                                        @if($attribute->is_required)
                                            - Required
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('attribute_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="value" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Value <span style="color: #e53e3e !important;">*</span>
                            </label>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" 
                                           class="form-control @error('value') is-invalid @enderror" 
                                           id="value" 
                                           name="value" 
                                           value="{{ old('value') }}" 
                                           required
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                           placeholder="Enter value (e.g., Red, Large, Cotton)"
                                           onkeyup="updateValuePreview(this.value)">
                                </div>
                                <div class="col-md-4">
                                    <div class="value-preview-container text-center">
                                        <label style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Preview:</label>
                                        <div id="value-preview" style="width: 60px !important; height: 60px !important; border-radius: 50% !important; background: #e2e8f0 !important; border: 3px solid #e2e8f0 !important; margin: 0 auto !important; transition: all 0.2s ease !important; display: flex !important; align-items: center !important; justify-content: center !important; font-size: 12px !important; font-weight: 600 !important; color: #4a5568 !important;">
                                            Preview
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.attributeValues.index') }}" class="btn btn-outline-secondary" 
                               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 14px 24px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary" 
                                    style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: 2px solid #3182ce !important; color: #ffffff !important; padding: 14px 24px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; box-shadow: 0 2px 4px rgba(49, 130, 206, 0.2) !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.background='linear-gradient(135deg, #2c5aa0 0%, #2a4a8a 100%) !important'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
                                    onmouseout="this.style.background='linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(49, 130, 206, 0.2) !important';">
                                <i class="bi bi-check-circle me-2"></i>Create Value
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bulk Value Creation -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-list-ul me-2" style="color: #3182ce !important;"></i>Bulk Add Values
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <form method="POST" action="{{ route('admin.attributeValues.store') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="bulk_attribute_id" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Select Attribute <span style="color: #e53e3e !important;">*</span>
                            </label>
                            <select class="form-control @error('attribute_id') is-invalid @enderror" 
                                    id="bulk_attribute_id" 
                                    name="attribute_id" 
                                    required
                                    style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                    onchange="updateBulkAttributePreview(this)">
                                <option value="">Choose an attribute...</option>
                                @foreach($attributes as $attribute)
                                    <option value="{{ $attribute->id }}" 
                                            data-type="{{ $attribute->type }}" 
                                            data-name="{{ $attribute->name }}">
                                        {{ $attribute->name }} ({{ ucfirst($attribute->type) }})
                                        @if($attribute->is_required)
                                            - Required
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="values_text" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Multiple Values <small style="color: #718096 !important; font-weight: 400 !important;">(one per line)</small>
                            </label>
                            <textarea class="form-control @error('values') is-invalid @enderror" 
                                      id="values_text" 
                                      name="values_text" 
                                      rows="8"
                                      style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; line-height: 1.6 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important; resize: vertical !important; font-family: 'Courier New', monospace !important;"
                                      placeholder="Red&#10;Blue&#10;Green&#10;Black&#10;White&#10;Yellow">{{ old('values_text') }}</textarea>
                            @error('values')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text" style="color: #718096 !important; font-size: 12px !important; margin-top: 6px !important;">Enter each value on a new line. Duplicates will be automatically skipped.</small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" name="bulk_create" value="1" class="btn btn-outline-primary" 
                                    style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 14px 24px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.25) !important';"
                                    onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <i class="bi bi-plus-square me-2"></i>Create Multiple Values
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Selected Attribute Info Card -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-info-circle me-2" style="color: #3182ce !important;"></i>Attribute Information
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div id="attribute-info" class="text-center" style="padding: 2rem !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 10px !important; border: 1px solid #e2e8f0 !important;">
                        <i class="bi bi-gear" style="color: #718096 !important; font-size: 3rem !important; margin-bottom: 1rem !important;"></i>
                        <h6 style="color: #4a5568 !important; font-weight: 500 !important;">Select an attribute to see its details</h6>
                    </div>
                </div>
            </div>

            <!-- Value Examples Card -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-lightbulb me-2" style="color: #3182ce !important;"></i>Value Examples
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div id="value-examples">
                        <div style="padding: 1.25rem !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 10px !important; border-left: 4px solid #f59e0b !important;">
                            <h6 style="color: #1a202c !important; font-weight: 600 !important; margin-bottom: 1rem !important;">💡 General Guidelines:</h6>
                            <ul style="margin-bottom: 0 !important; padding-left: 1.25rem !important;">
                                <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Use clear, descriptive values</li>
                                <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Keep values consistent</li>
                                <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0 !important;">Consider customer understanding</li>
                            </ul>
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
    // Convert textarea input to array for bulk creation
    const bulkForm = document.querySelector('form[name="bulk_create"]');
    if (bulkForm) {
        bulkForm.addEventListener('submit', function(e) {
            const textarea = document.getElementById('values_text');
            const lines = textarea.value.split('\n').filter(line => line.trim() !== '');
            
            // Create hidden inputs for each line
            lines.forEach((line, index) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `values[${index}]`;
                input.value = line.trim();
                this.appendChild(input);
            });
        });
    }
});

// Update attribute information display
function updateAttributePreview(select) {
    const selectedOption = select.options[select.selectedIndex];
    const attributeInfo = document.getElementById('attribute-info');
    const valueExamples = document.getElementById('value-examples');
    
    if (selectedOption.value) {
        const type = selectedOption.dataset.type;
        const name = selectedOption.dataset.name;
        const isRequired = selectedOption.textContent.includes('Required');
        
        // Update attribute info
        const typeColors = {
            'text': '#3182ce',
            'select': '#10b981', 
            'checkbox': '#f59e0b',
            'radio': '#8b5cf6'
        };
        
        const typeIcons = {
            'text': 'input-cursor-text',
            'select': 'list-ul',
            'checkbox': 'check-square',
            'radio': 'circle'
        };
        
        attributeInfo.innerHTML = `
            <div class="type-icon" style="background: ${typeColors[type] || '#3182ce'} !important; width: 50px !important; height: 50px !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important; margin: 0 auto 12px auto !important;">
                <i class="bi bi-${typeIcons[type] || 'gear'}" style="color: #ffffff !important; font-size: 20px !important;"></i>
            </div>
            <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 8px !important;">${name}</h6>
            <span class="badge" style="background-color: ${typeColors[type] || '#3182ce'} !important; color: #ffffff !important; font-size: 11px !important; padding: 6px 12px !important; border-radius: 20px !important; text-transform: uppercase !important;">
                ${type} • ${isRequired ? 'Required' : 'Optional'}
            </span>
        `;
        
        // Update examples based on attribute name
        updateValueExamples(name, type);
    } else {
        attributeInfo.innerHTML = `
            <i class="bi bi-gear" style="color: #718096 !important; font-size: 3rem !important; margin-bottom: 1rem !important;"></i>
            <h6 style="color: #4a5568 !important; font-weight: 500 !important;">Select an attribute to see its details</h6>
        `;
        
        valueExamples.innerHTML = `
            <div style="padding: 1.25rem !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 10px !important; border-left: 4px solid #f59e0b !important;">
                <h6 style="color: #1a202c !important; font-weight: 600 !important; margin-bottom: 1rem !important;">💡 General Guidelines:</h6>
                <ul style="margin-bottom: 0 !important; padding-left: 1.25rem !important;">
                    <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Use clear, descriptive values</li>
                    <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Keep values consistent</li>
                    <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0 !important;">Consider customer understanding</li>
                </ul>
            </div>
        `;
    }
}

function updateBulkAttributePreview(select) {
    const selectedOption = select.options[select.selectedIndex];
    if (selectedOption.value) {
        const name = selectedOption.dataset.name;
        updateValueExamples(name);
    }
}

function updateValueExamples(attributeName, type = '') {
    const valueExamples = document.getElementById('value-examples');
    let content = '';
    
    if (attributeName.toLowerCase() === 'size') {
        content = `
            <div style="padding: 1.25rem !important; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important; border-radius: 10px !important; border-left: 4px solid #10b981 !important;">
                <h6 style="color: #1a202c !important; font-weight: 600 !important; margin-bottom: 1rem !important;">📏 Size Examples:</h6>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge" style="background: #10b981 !important; color: #ffffff !important; padding: 6px 12px !important;">XS</span>
                    <span class="badge" style="background: #10b981 !important; color: #ffffff !important; padding: 6px 12px !important;">S</span>
                    <span class="badge" style="background: #10b981 !important; color: #ffffff !important; padding: 6px 12px !important;">M</span>
                    <span class="badge" style="background: #10b981 !important; color: #ffffff !important; padding: 6px 12px !important;">L</span>
                    <span class="badge" style="background: #10b981 !important; color: #ffffff !important; padding: 6px 12px !important;">XL</span>
                    <span class="badge" style="background: #10b981 !important; color: #ffffff !important; padding: 6px 12px !important;">XXL</span>
                </div>
            </div>
        `;
    } else if (attributeName.toLowerCase() === 'color') {
        content = `
            <div style="padding: 1.25rem !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 10px !important; border-left: 4px solid #3182ce !important;">
                <h6 style="color: #1a202c !important; font-weight: 600 !important; margin-bottom: 1rem !important;">🎨 Color Examples:</h6>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge" style="background: #000000 !important; color: #ffffff !important; padding: 6px 12px !important;">Black</span>
                    <span class="badge" style="background: #ffffff !important; color: #000000 !important; border: 1px solid #000000 !important; padding: 6px 12px !important;">White</span>
                    <span class="badge" style="background: #ef4444 !important; color: #ffffff !important; padding: 6px 12px !important;">Red</span>
                    <span class="badge" style="background: #3b82f6 !important; color: #ffffff !important; padding: 6px 12px !important;">Blue</span>
                    <span class="badge" style="background: #10b981 !important; color: #ffffff !important; padding: 6px 12px !important;">Green</span>
                </div>
            </div>
        `;
    } else if (attributeName.toLowerCase() === 'material') {
        content = `
            <div style="padding: 1.25rem !important; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border-radius: 10px !important; border-left: 4px solid #8b5cf6 !important;">
                <h6 style="color: #1a202c !important; font-weight: 600 !important; margin-bottom: 1rem !important;">🧵 Material Examples:</h6>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge" style="background: #8b5cf6 !important; color: #ffffff !important; padding: 6px 12px !important;">Cotton</span>
                    <span class="badge" style="background: #8b5cf6 !important; color: #ffffff !important; padding: 6px 12px !important;">Polyester</span>
                    <span class="badge" style="background: #8b5cf6 !important; color: #ffffff !important; padding: 6px 12px !important;">Wool</span>
                    <span class="badge" style="background: #8b5cf6 !important; color: #ffffff !important; padding: 6px 12px !important;">Silk</span>
                    <span class="badge" style="background: #8b5cf6 !important; color: #ffffff !important; padding: 6px 12px !important;">Linen</span>
                </div>
            </div>
        `;
    } else {
        content = `
            <div style="padding: 1.25rem !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 10px !important; border-left: 4px solid #f59e0b !important;">
                <h6 style="color: #1a202c !important; font-weight: 600 !important; margin-bottom: 1rem !important;">💡 ${attributeName} Examples:</h6>
                <ul style="margin-bottom: 0 !important; padding-left: 1.25rem !important;">
                    <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Use clear, descriptive values</li>
                    <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Keep values consistent</li>
                    <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0 !important;">Consider customer understanding</li>
                </ul>
            </div>
        `;
    }
    
    valueExamples.innerHTML = content;
}

// Value preview function
function updateValuePreview(value) {
    const preview = document.getElementById('value-preview');
    const attributeSelect = document.getElementById('attribute_id');
    const selectedOption = attributeSelect.options[attributeSelect.selectedIndex];
    
    if (!preview) return;
    
    if (selectedOption.value && selectedOption.dataset.name.toLowerCase() === 'color') {
        const colorMap = {
            'black': '#000000',
            'white': '#ffffff', 
            'red': '#ef4444',
            'blue': '#3b82f6',
            'green': '#10b981',
            'yellow': '#fbbf24',
            'pink': '#ec4899',
            'purple': '#8b5cf6',
            'orange': '#f97316',
            'brown': '#92400e',
            'gray': '#6b7280',
            'grey': '#6b7280'
        };
        
        const color = colorMap[value.toLowerCase()] || '#e2e8f0';
        preview.style.backgroundColor = color;
        preview.style.borderColor = color === '#ffffff' ? '#000000' : color;
        preview.innerHTML = '';
        
        if (value.trim() !== '') {
            preview.style.transform = 'scale(1.1)';
            preview.style.boxShadow = `0 4px 12px ${color}40`;
        } else {
            preview.style.transform = 'scale(1)';
            preview.style.boxShadow = 'none';
            preview.style.backgroundColor = '#e2e8f0';
            preview.style.borderColor = '#e2e8f0';
            preview.innerHTML = 'Preview';
        }
    } else {
        if (value.trim() !== '') {
            preview.innerHTML = value.length > 8 ? value.substring(0, 8) + '...' : value;
            preview.style.backgroundColor = '#3182ce';
            preview.style.color = '#ffffff';
            preview.style.transform = 'scale(1.05)';
        } else {
            preview.innerHTML = 'Preview';
            preview.style.backgroundColor = '#e2e8f0';
            preview.style.color = '#4a5568';
            preview.style.transform = 'scale(1)';
        }
    }
}
</script>
@endpush

@push('styles')
<style>
    /* CLEAN ATTRIBUTE VALUES CREATE PAGE - Professional Styling */
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
    
    .value-preview-container {
        transition: all 0.2s ease !important;
    }
    
    #value-preview {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .type-icon {
        transition: all 0.2s ease !important;
    }
    
    .type-icon:hover {
        transform: scale(1.1) !important;
    }
</style>
@endpush
@endsection
