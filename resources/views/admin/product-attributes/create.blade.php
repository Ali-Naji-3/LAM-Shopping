@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Compact Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0" style="color: #1a202c; font-weight: 700;">🔗 Assign Product Attributes</h1>
                    <p style="color: #4a5568; font-size: 14px; margin-bottom: 0;">Link attributes to products with pricing</p>
                </div>
                <a href="{{ route('admin.productAttributes.index') }}" class="btn btn-secondary" style="font-weight: 600;">
                    <i class="fas fa-arrow-left me-1"></i> Back to Assignments
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Form -->
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 15px;">
                    <h6 class="m-0" style="color: #2d3748; font-weight: 700; font-size: 15px;">Attribute Assignment</h6>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('admin.productAttributes.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-box text-primary me-1"></i> Product *
                                    </label>
                                    <select class="form-control @error('product_id') is-invalid @enderror" name="product_id" required>
                                        <option value="">Select Product</option>
                                        @foreach(\App\Models\Product::with('brand')->get() as $product)
                                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }} ({{ $product->sku }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-list text-info me-1"></i> Attribute Value *
                                    </label>
                                    <select class="form-control @error('attribute_value_id') is-invalid @enderror" name="attribute_value_id" required>
                                        <option value="">Select Attribute Value</option>
                                        @foreach(\App\Models\AttributeValue::with('attribute')->get() as $value)
                                            <option value="{{ $value->id }}" {{ old('attribute_value_id') == $value->id ? 'selected' : '' }}>
                                                {{ $value->attribute->name ?? 'Unknown' }}: {{ $value->value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('attribute_value_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                <i class="fas fa-dollar-sign text-success me-1"></i> Additional Price
                            </label>
                            <input type="number" step="0.01" 
                                   class="form-control @error('additional_price') is-invalid @enderror" 
                                   name="additional_price" value="{{ old('additional_price', 0) }}" 
                                   placeholder="0.00">
                            <small class="form-text text-muted">Extra cost for this attribute (leave 0 if no additional cost)</small>
                            @error('additional_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" style="font-weight: 600; border-radius: 8px; padding: 10px 20px;">
                                <i class="fas fa-link me-1"></i> Assign Attribute
                            </button>
                            <a href="{{ route('admin.productAttributes.index') }}" class="btn btn-secondary" style="font-weight: 600; border-radius: 8px; padding: 10px 20px;">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Assignment Guidelines -->
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%); color: white; padding: 15px;">
                    <h6 class="m-0" style="font-weight: 700; font-size: 14px;">📋 Assignment Guidelines</h6>
                </div>
                <div class="card-body p-3">
                    <div style="color: #2d3748; font-size: 12px; line-height: 1.5;">
                        <p class="mb-2"><strong>🔗 Attribute Linking:</strong></p>
                        <ul class="mb-3" style="padding-left: 16px;">
                            <li>Each product can have multiple attributes</li>
                            <li>Same attribute value can be used for multiple products</li>
                            <li>Additional pricing is optional</li>
                        </ul>
                        
                        <p class="mb-2"><strong>💰 Pricing Guidelines:</strong></p>
                        <ul class="mb-0" style="padding-left: 16px;">
                            <li>Set additional cost for premium attributes</li>
                            <li>Use 0 for standard attributes</li>
                            <li>Consider customer impact on pricing</li>
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
</style>
@endpush
@endsection
