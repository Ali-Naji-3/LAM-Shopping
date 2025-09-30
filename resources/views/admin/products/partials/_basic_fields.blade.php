{{-- Shared Basic Information Fields Component --}}
<!-- Basic Information -->
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
            <input type="text" 
                   class="form-control @error('name') is-invalid @enderror" 
                   id="name" 
                   name="name" 
                   value="{{ old('name', $product->name ?? '') }}" 
                   required
                   {{ $readonly ?? false ? 'readonly' : '' }}>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" 
                   class="form-control @error('slug') is-invalid @enderror" 
                   id="slug" 
                   name="slug" 
                   value="{{ old('slug', $product->slug ?? '') }}"
                   {{ $readonly ?? false ? 'readonly' : '' }}>
            @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Auto-generated from product name if left empty</small>
        </div>
    </div>
</div>

<!-- Category and Brand -->
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
            <select class="form-control @error('category_id') is-invalid @enderror" 
                    id="category_id" 
                    name="category_id" 
                    required
                    {{ $readonly ?? false ? 'disabled' : '' }}>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                            {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->parent_id ? '└─ ' : '' }}{{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="brand_id" class="form-label">Brand</label>
            <select class="form-control @error('brand_id') is-invalid @enderror" 
                    id="brand_id" 
                    name="brand_id"
                    {{ $readonly ?? false ? 'disabled' : '' }}>
                <option value="">Select Brand (Optional)</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" 
                            {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
            @error('brand_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<!-- Description -->
<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control @error('description') is-invalid @enderror" 
              id="description" 
              name="description" 
              rows="4"
              {{ $readonly ?? false ? 'readonly' : '' }}>{{ old('description', $product->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
