@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Compact Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0" style="color: #1a202c; font-weight: 700;">🏷️ Brand Details</h1>
                    <p style="color: #4a5568; font-size: 14px; margin-bottom: 0;">{{ $brand->name }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-warning" style="font-weight: 600;">
                        <i class="fas fa-edit me-1"></i> Edit Brand
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
            <!-- Brand Information -->
            <div class="card shadow border-0 mb-3" style="border-radius: 12px;">
                <div class="card-header" style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 15px;">
                    <h6 class="m-0" style="color: #2d3748; font-weight: 700; font-size: 15px;">📋 Brand Information</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Brand Name</label>
                                <div style="color: #1a202c; font-weight: 700; font-size: 24px;">{{ $brand->name }}</div>
                            </div>
                            
                            <div class="mb-3">
                                <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Slug</label>
                                <div style="color: #4299e1; font-weight: 600; font-size: 14px;">{{ $brand->slug }}</div>
                            </div>
                            
                            @if($brand->description)
                            <div class="mb-3">
                                <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Description</label>
                                <div style="color: #2d3748; font-size: 14px; line-height: 1.6;">{{ $brand->description }}</div>
                            </div>
                            @endif
                        </div>
                        
                        <div class="col-md-4">
                            @if($brand->image)
                            <div class="text-center">
                                <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Brand Logo</label>
                                <div class="mt-2">
                                    <img src="{{ Storage::url($brand->image) }}" alt="{{ $brand->name }}" 
                                         class="img-fluid rounded" style="max-width: 150px; border: 2px solid #e2e8f0;">
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Brand Statistics -->
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 15px;">
                    <h6 class="m-0" style="color: #2d3748; font-weight: 700; font-size: 15px;">📊 Brand Statistics</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="stat-item p-3" style="background: #f0fff4; border-radius: 8px; border: 1px solid #68d391;">
                                <div style="color: #22543d; font-size: 20px; font-weight: 800;">{{ $connectionCounts['products_count'] ?? 0 }}</div>
                                <div style="color: #68d391; font-size: 11px; font-weight: 600; text-transform: uppercase;">Products</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item p-3" style="background: #eff6ff; border-radius: 8px; border: 1px solid #60a5fa;">
                                <div style="color: #1e40af; font-size: 20px; font-weight: 800;">{{ $connectionCounts['reviews_count'] ?? 0 }}</div>
                                <div style="color: #60a5fa; font-size: 11px; font-weight: 600; text-transform: uppercase;">Reviews</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item p-3" style="background: #fef3c7; border-radius: 8px; border: 1px solid #f59e0b;">
                                <div style="color: #92400e; font-size: 20px; font-weight: 800;">{{ $connectionCounts['contacts_count'] ?? 0 }}</div>
                                <div style="color: #f59e0b; font-size: 11px; font-weight: 600; text-transform: uppercase;">Contacts</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item p-3" style="background: #f3e8ff; border-radius: 8px; border: 1px solid #a855f7;">
                                <div style="color: #7c3aed; font-size: 20px; font-weight: 800;">{{ $brand->is_active ? 'Active' : 'Inactive' }}</div>
                                <div style="color: #a855f7; font-size: 11px; font-weight: 600; text-transform: uppercase;">Status</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card shadow border-0 mb-3" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%); color: white; padding: 15px;">
                    <h6 class="m-0" style="font-weight: 700; font-size: 14px;">⚡ Quick Actions</h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.products.index') }}?brand_id={{ $brand->id }}" class="btn btn-outline-primary" style="font-weight: 600;">
                            <i class="fas fa-box me-1"></i> View Brand Products
                        </a>
                        <a href="{{ route('admin.reviews.index') }}?brand_id={{ $brand->id }}" class="btn btn-outline-success" style="font-weight: 600;">
                            <i class="fas fa-star me-1"></i> View Brand Reviews
                        </a>
                        <button class="btn btn-outline-info" onclick="viewBrandAnalytics()" style="font-weight: 600;">
                            <i class="fas fa-chart-bar me-1"></i> Brand Analytics
                        </button>
                        <button class="btn btn-outline-warning" onclick="manageBrandContacts()" style="font-weight: 600;">
                            <i class="fas fa-envelope me-1"></i> Manage Contacts
                        </button>
                    </div>
                </div>
            </div>

            <!-- Brand Status -->
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, {{ $brand->is_active ? '#48bb78' : '#f56565' }} 0%, {{ $brand->is_active ? '#38a169' : '#e53e3e' }} 100%); color: white; padding: 15px;">
                    <h6 class="m-0" style="font-weight: 700; font-size: 14px;">📊 Brand Status</h6>
                </div>
                <div class="card-body p-3">
                    <div class="text-center">
                        <div class="mb-3">
                            <span class="badge badge-{{ $brand->is_active ? 'success' : 'danger' }}" style="font-size: 14px; padding: 8px 16px;">
                                {{ $brand->is_active ? '✅ Active' : '❌ Inactive' }}
                            </span>
                        </div>
                        
                        <div class="mb-2">
                            <div style="color: #718096; font-size: 12px;">Created:</div>
                            <div style="color: #2d3748; font-weight: 600;">{{ $brand->created_at->format('M d, Y') }}</div>
                        </div>
                        
                        <div>
                            <div style="color: #718096; font-size: 12px;">Last Updated:</div>
                            <div style="color: #2d3748; font-weight: 600;">{{ $brand->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function viewBrandAnalytics() {
    showNotification('Brand analytics feature coming soon!', 'info');
}

function manageBrandContacts() {
    showNotification('Brand contacts feature coming soon!', 'info');
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = `
        top: 20px; 
        right: 20px; 
        z-index: 9999; 
        min-width: 300px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        border-radius: 8px;
        border: none;
        font-size: 13px;
    `;
    
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} mr-2"></i>
            <span>${message}</span>
            <button type="button" class="close ml-auto" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 4000);
}
</script>
@endpush
@endsection
