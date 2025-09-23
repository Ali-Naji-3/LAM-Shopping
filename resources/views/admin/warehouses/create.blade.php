@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                ➕ Add New Warehouse
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                Create a new warehouse facility for inventory management
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.warehouses.index') }}" class="btn btn-outline-secondary" 
               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                <i class="bi bi-arrow-left me-2"></i>Back to Warehouses
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.warehouses.store') }}">
        @csrf

        <div class="row">
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-info-circle me-2" style="color: #3182ce !important;"></i>Basic Information
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Warehouse Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Warehouse Name <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" required
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                           onfocus="this.style.borderColor='#3182ce !important'; this.style.boxShadow='0 0 0 3px rgba(49, 130, 206, 0.1) !important';"
                                           onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none'; generateWarehouseCode();"
                                           placeholder="Enter warehouse name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Warehouse Code -->
                                <div class="mb-3">
                                    <label for="code" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Warehouse Code <span style="color: #e53e3e !important;">*</span>
                                        <small style="color: #4a5568 !important; font-weight: 400 !important;">(Auto-generated)</small>
                                    </label>
                                    <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" 
                                           value="{{ old('code') }}" required
                                           style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border: 2px solid #3182ce !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 600 !important; font-family: monospace !important;"
                                           placeholder="Will be auto-generated">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Location -->
                                <div class="mb-3">
                                    <label for="location" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Location <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" 
                                           value="{{ old('location') }}" required
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                           onfocus="this.style.borderColor='#f59e0b !important'; this.style.boxShadow='0 0 0 3px rgba(245, 158, 11, 0.1) !important';"
                                           onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none'; generateWarehouseCode();"
                                           placeholder="Enter complete address (City, State, Country)">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Manager -->
                                <div class="mb-3">
                                    <label for="manager" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Warehouse Manager
                                        <small style="color: #4a5568 !important; font-weight: 400 !important;">(Optional)</small>
                                    </label>
                                    <input type="text" name="manager" id="manager" class="form-control @error('manager') is-invalid @enderror" 
                                           value="{{ old('manager') }}"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                           onfocus="this.style.borderColor='#8b5cf6 !important'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1) !important';"
                                           onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none';"
                                           placeholder="Enter manager full name">
                                    @error('manager')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Contact Number -->
                                <div class="mb-3">
                                    <label for="contact_number" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Contact Number
                                        <small style="color: #4a5568 !important; font-weight: 400 !important;">(Optional)</small>
                                    </label>
                                    <input type="text" name="contact_number" id="contact_number" class="form-control @error('contact_number') is-invalid @enderror" 
                                           value="{{ old('contact_number') }}"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                           onfocus="this.style.borderColor='#10b981 !important'; this.style.boxShadow='0 0 0 3px rgba(16, 185, 129, 0.1) !important';"
                                           onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none';"
                                           placeholder="Enter phone number (e.g., +1-555-0123)">
                                    @error('contact_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="is_active" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Warehouse Status
                                    </label>
                                    <div class="form-check" style="padding: 1rem !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 10px !important; border-left: 4px solid #10b981 !important;">
                                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" 
                                               value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                               style="width: 20px !important; height: 20px !important; margin-top: 2px !important;">
                                        <label for="is_active" class="form-check-label" style="color: #1a202c !important; font-weight: 500 !important; font-size: 15px !important; margin-left: 8px !important;">
                                            <i class="bi bi-check-circle me-2" style="color: #10b981 !important;"></i>Activate warehouse immediately
                                        </label>
                                        <div style="color: #4a5568 !important; font-size: 13px !important; margin-top: 4px !important; margin-left: 28px !important;">
                                            Active warehouses can receive inventory and process orders
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Warehouse Guidelines -->
                <div class="card" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border: 1px solid #e9d5ff !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%) !important; border-bottom: 1px solid #e9d5ff !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #ffffff !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-lightbulb me-2"></i>Warehouse Guidelines
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="guideline-section" style="margin-bottom: 1.5rem !important;">
                                    <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 1rem !important;">
                                        📝 Naming Guidelines
                                    </h6>
                                    <ul style="color: #4a5568 !important; font-size: 14px !important; line-height: 1.6 !important; margin: 0 !important; padding-left: 1.5rem !important;">
                                        <li>Use descriptive names that indicate purpose or region</li>
                                        <li>Include geographic identifiers for easy location</li>
                                        <li>Keep names professional and consistent</li>
                                        <li>Avoid special characters in warehouse names</li>
                                    </ul>
                                </div>

                                <div class="guideline-section">
                                    <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 1rem !important;">
                                        🏗️ Location Best Practices
                                    </h6>
                                    <ul style="color: #4a5568 !important; font-size: 14px !important; line-height: 1.6 !important; margin: 0 !important; padding-left: 1.5rem !important;">
                                        <li>Include full address with city, state, country</li>
                                        <li>Consider strategic locations near major shipping routes</li>
                                        <li>Account for proximity to customer bases</li>
                                        <li>Ensure accessibility for delivery vehicles</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="guideline-section" style="margin-bottom: 1.5rem !important;">
                                    <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 1rem !important;">
                                        🔢 Code Generation
                                    </h6>
                                    <ul style="color: #4a5568 !important; font-size: 14px !important; line-height: 1.6 !important; margin: 0 !important; padding-left: 1.5rem !important;">
                                        <li>Codes are automatically generated from name and location</li>
                                        <li>Format: [NAME3][LOC2][NUMBER3] (e.g., MANNY001)</li>
                                        <li>Codes are unique and cannot be duplicated</li>
                                        <li>You can modify the generated code if needed</li>
                                    </ul>
                                </div>

                                <div class="guideline-section">
                                    <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 1rem !important;">
                                        👨‍💼 Management Setup
                                    </h6>
                                    <ul style="color: #4a5568 !important; font-size: 14px !important; line-height: 1.6 !important; margin: 0 !important; padding-left: 1.5rem !important;">
                                        <li>Assign a warehouse manager for better oversight</li>
                                        <li>Provide contact numbers for emergency situations</li>
                                        <li>Manager assignment improves accountability</li>
                                        <li>Contact information enables direct communication</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Preview Card -->
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                            <i class="bi bi-eye me-2" style="color: #06b6d4 !important;"></i>Warehouse Preview
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 1.5rem !important;">
                        <div class="warehouse-preview" style="padding: 1.5rem !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 10px !important; border: 1px solid #f1f5f9 !important;">
                            <div class="preview-item mb-3">
                                <div style="color: #4a5568 !important; font-size: 12px !important; font-weight: 600 !important; text-transform: uppercase; letter-spacing: 0.5px !important;">Name</div>
                                <div id="preview-name" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">Enter warehouse name...</div>
                            </div>
                            <div class="preview-item mb-3">
                                <div style="color: #4a5568 !important; font-size: 12px !important; font-weight: 600 !important; text-transform: uppercase; letter-spacing: 0.5px !important;">Code</div>
                                <div id="preview-code" style="color: #3182ce !important; font-weight: 700 !important; font-size: 14px !important; font-family: monospace !important;">AUTO-GENERATED</div>
                            </div>
                            <div class="preview-item mb-3">
                                <div style="color: #4a5568 !important; font-size: 12px !important; font-weight: 600 !important; text-transform: uppercase; letter-spacing: 0.5px !important;">Location</div>
                                <div id="preview-location" style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important;">Enter location...</div>
                            </div>
                            <div class="preview-item mb-3">
                                <div style="color: #4a5568 !important; font-size: 12px !important; font-weight: 600 !important; text-transform: uppercase; letter-spacing: 0.5px !important;">Manager</div>
                                <div id="preview-manager" style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important;">No manager assigned</div>
                            </div>
                            <div class="preview-item">
                                <div style="color: #4a5568 !important; font-size: 12px !important; font-weight: 600 !important; text-transform: uppercase; letter-spacing: 0.5px !important;">Status</div>
                                <div id="preview-status">
                                    <span class="badge" style="background: #10b981 !important; color: #ffffff !important; font-size: 11px !important; padding: 4px 8px !important; border-radius: 12px !important; text-transform: uppercase !important;">
                                        Active
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                            <i class="bi bi-gear me-2" style="color: #3182ce !important;"></i>Actions
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 1.5rem !important;">
                        <div class="d-grid gap-2">
                            <!-- Create Warehouse Button -->
                            <button type="submit" class="btn btn-primary w-100"
                                    style="background: linear-gradient(135deg, #3182ce 0%, #1e40af 100%) !important; border: none !important; color: #ffffff !important; padding: 14px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 16px !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(49, 130, 206, 0.4) !important';"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <i class="bi bi-plus-circle me-2"></i>Create Warehouse
                            </button>

                            <!-- Cancel Button -->
                            <a href="{{ route('admin.warehouses.index') }}" class="btn btn-outline-secondary w-100"
                               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Generate warehouse code based on name and location
    function generateWarehouseCode() {
        const name = document.getElementById('name').value.trim();
        const location = document.getElementById('location').value.trim();
        
        if (name && location) {
            // Extract name code (first 3 letters)
            const nameCode = name.replace(/[^A-Za-z]/g, '').substring(0, 3).toUpperCase();
            
            // Extract location code (first 2 letters)
            const locationCode = location.replace(/[^A-Za-z]/g, '').substring(0, 2).toUpperCase();
            
            // Generate number (you might want to make this dynamic based on existing warehouses)
            const number = '001';
            
            const code = nameCode + locationCode + number;
            document.getElementById('code').value = code;
            updatePreview();
        }
    }

    // Update live preview
    function updatePreview() {
        const name = document.getElementById('name').value || 'Enter warehouse name...';
        const code = document.getElementById('code').value || 'AUTO-GENERATED';
        const location = document.getElementById('location').value || 'Enter location...';
        const manager = document.getElementById('manager').value || 'No manager assigned';
        const isActive = document.getElementById('is_active').checked;
        
        document.getElementById('preview-name').textContent = name;
        document.getElementById('preview-code').textContent = code;
        document.getElementById('preview-location').textContent = location;
        document.getElementById('preview-manager').textContent = manager;
        
        const statusBadge = document.getElementById('preview-status');
        statusBadge.innerHTML = `
            <span class="badge" style="background: ${isActive ? '#10b981' : '#ef4444'} !important; color: #ffffff !important; font-size: 11px !important; padding: 4px 8px !important; border-radius: 12px !important; text-transform: uppercase !important;">
                ${isActive ? 'Active' : 'Inactive'}
            </span>
        `;
    }

    // Initialize event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listeners for live preview
        document.getElementById('name').addEventListener('input', updatePreview);
        document.getElementById('code').addEventListener('input', updatePreview);
        document.getElementById('location').addEventListener('input', updatePreview);
        document.getElementById('manager').addEventListener('input', updatePreview);
        document.getElementById('is_active').addEventListener('change', updatePreview);
        
        // Initial preview update
        updatePreview();
    });
</script>
@endpush
@endsection
