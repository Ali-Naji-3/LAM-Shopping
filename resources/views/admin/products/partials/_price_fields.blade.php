{{-- Shared Price and Stock Fields Component --}}
<!-- Price and Stock -->
<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <label for="price" class="form-label">Sale Price <span class="text-danger">*</span></label>
            <input type="number" 
                   step="0.01" 
                   class="form-control @error('price') is-invalid @enderror" 
                   id="price" 
                   name="price" 
                   value="{{ old('price', $product->regular_price ?? '') }}" 
                   required 
                   placeholder="0.00"
                   {{ $readonly ?? false ? 'readonly' : '' }}>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">The price customers will pay</small>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="mb-3">
            <label for="sale_price" class="form-label">Regular Price</label>
            <input type="number" 
                   step="0.01" 
                   class="form-control @error('sale_price') is-invalid @enderror" 
                   id="sale_price" 
                   name="sale_price" 
                   value="{{ old('sale_price', $product->sale_price ?? '') }}" 
                   placeholder="0.00"
                   {{ $readonly ?? false ? 'readonly' : '' }}>
            @error('sale_price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Original price (optional, for showing discount)</small>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="mb-3">
            <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
            <input type="number" 
                   class="form-control @error('stock') is-invalid @enderror" 
                   id="stock" 
                   name="stock" 
                   value="{{ old('stock', $product->quantity ?? $product->stock ?? 1) }}" 
                   min="1" 
                   required
                   {{ $readonly ?? false ? 'readonly' : '' }}>
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Products must have at least 1 item in stock</small>
        </div>
    </div>
</div>
