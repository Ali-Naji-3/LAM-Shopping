@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                ✏️ Edit Warehouse
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                {{ $warehouse->name }} • {{ $warehouse->code }} • Update warehouse details
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.warehouses.show', $warehouse) }}" class="btn btn-outline-info"
               style="color: #06b6d4 !important; border-color: #06b6d4 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#06b6d4 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#06b6d4 !important';">
                <i class="bi bi-eye me-2"></i>View Warehouse
            </a>
            <a href="{{ route('admin.warehouses.index') }}" class="btn btn-outline-secondary" 
               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                <i class="bi bi-arrow-left me-2"></i>Back to Warehouses
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.warehouses.update', $warehouse) }}">
        @csrf
        @method('PUT')

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
                                           value="{{ old('name', $warehouse->name) }}" required
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                           onfocus="this.style.borderColor='#3182ce !important'; this.style.boxShadow='0 0 0 3px rgba(49, 130, 206, 0.1) !important';"
                                           onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none';"
                                           placeholder="Enter warehouse name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Warehouse Code -->
                                <div class="mb-3">
                                    <label for="code" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Warehouse Code <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" 
                                           value="{{ old('code', $warehouse->code) }}" required
                                           style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border: 2px solid #3182ce !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 600 !important; font-family: monospace !important;"
                                           placeholder="Enter unique warehouse code">
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
                                           value="{{ old('location', $warehouse->location) }}" required
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                           onfocus="this.style.borderColor='#f59e0b !important'; this.style.boxShadow='0 0 0 3px rgba(245, 158, 11, 0.1) !important';"
                                           onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none';"
                                           placeholder="Enter complete address">
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
                                           value="{{ old('manager', $warehouse->manager) }}"
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
                                           value="{{ old('contact_number', $warehouse->contact_number) }}"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                           onfocus="this.style.borderColor='#10b981 !important'; this.style.boxShadow='0 0 0 3px rgba(16, 185, 129, 0.1) !important';"
                                           onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none';"
                                           placeholder="Enter phone number">
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
                                               value="1" {{ old('is_active', $warehouse->is_active) ? 'checked' : '' }}
                                               style="width: 20px !important; height: 20px !important; margin-top: 2px !important;">
                                        <label for="is_active" class="form-check-label" style="color: #1a202c !important; font-weight: 500 !important; font-size: 15px !important; margin-left: 8px !important;">
                                            <i class="bi bi-check-circle me-2" style="color: #10b981 !important;"></i>Warehouse is active
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
            </div>

            <div class="col-lg-4">
                <!-- Warehouse Statistics -->
                <div class="card mb-4" style="background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%) !important; border: 1px solid #475569 !important; border-radius: 12px !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: transparent !important; border-bottom: 1px solid #475569 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
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
                            <i class="bi bi-bar-chart me-2" style="color: #60a5fa; filter: drop-shadow(0 0 8px rgba(96, 165, 250, 0.6)); animation: iconGlow 3s ease-in-out infinite;"></i>Warehouse Statistics
                        </h5>
                    </div>
                    <div class="card-body" style="background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%) !important; padding: 2rem !important; border-radius: 0 0 12px 12px !important;">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="stat-number h4 mb-1" style="color: #ffffff !important; font-weight: 700; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">
                                    {{ $warehouseAnalytics['inventory_count'] }}
                                </div>
                                <div class="stat-label small" style="color: #ffffff !important; opacity: 0.9; font-weight: 500;">Inventory Items</div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="stat-number h4 mb-1" style="color: #ffffff !important; font-weight: 700; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">
                                    {{ $warehouseAnalytics['contacts_count'] }}
                                </div>
                                <div class="stat-label small" style="color: #ffffff !important; opacity: 0.9; font-weight: 500;">Contacts</div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="stat-number h4 mb-1" style="color: #ffffff !important; font-weight: 700; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">
                                    {{ number_format($warehouseAnalytics['total_stock']) }}
                                </div>
                                <div class="stat-label small" style="color: #ffffff !important; opacity: 0.9; font-weight: 500;">Total Stock</div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="stat-number h4 mb-1" style="color: #ffffff !important; font-weight: 700; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">
                                    {{ $warehouseAnalytics['pending_contacts'] }}
                                </div>
                                <div class="stat-label small" style="color: #ffffff !important; opacity: 0.9; font-weight: 500;">Pending Contacts</div>
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
                            <!-- Update Warehouse Button -->
                            <button type="submit" class="btn btn-primary w-100"
                                    style="background: linear-gradient(135deg, #3182ce 0%, #1e40af 100%) !important; border: none !important; color: #ffffff !important; padding: 14px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 16px !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(49, 130, 206, 0.4) !important';"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <i class="bi bi-check-circle me-2"></i>Update Warehouse
                            </button>

                            <!-- View Warehouse Button -->
                            <a href="{{ route('admin.warehouses.show', $warehouse) }}" class="btn btn-outline-info w-100"
                               style="color: #06b6d4 !important; border-color: #06b6d4 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#06b6d4 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#06b6d4 !important';">
                                <i class="bi bi-eye me-2"></i>View Warehouse Details
                            </a>

                            <!-- Cancel Button -->
                            <a href="{{ route('admin.warehouses.index') }}" class="btn btn-outline-secondary w-100"
                               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                                <i class="bi bi-x-circle me-2"></i>Cancel Changes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
    /* CLEAN WAREHOUSES EDIT PAGE - Professional Styling */
    .form-control::placeholder {
        color: #9ca3af !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    
    .form-control::-webkit-input-placeholder { color: #9ca3af !important; opacity: 1 !important; }
    .form-control::-moz-placeholder { color: #9ca3af !important; opacity: 1 !important; }
    .form-control:-ms-input-placeholder { color: #9ca3af !important; opacity: 1 !important; }
    .form-control:-moz-placeholder { color: #9ca3af !important; opacity: 1 !important; }
    
    /* Eye-catching animations */
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    
    @keyframes iconGlow {
        0%, 100% { filter: drop-shadow(0 0 8px rgba(96, 165, 250, 0.6)); }
        50% { filter: drop-shadow(0 0 15px rgba(96, 165, 250, 0.9)) drop-shadow(0 0 25px rgba(96, 165, 250, 0.6)); }
    }
    
    .eye-catching-title {
        animation: shimmer 4s ease-in-out infinite alternate;
    }
    
    .card-header:has(.eye-catching-title) {
        position: relative;
        overflow: hidden;
    }
    
    .card-header:has(.eye-catching-title):hover {
        box-shadow: 0 0 25px rgba(96, 165, 250, 0.3) !important;
    }
</style>
@endpush
@endsection
