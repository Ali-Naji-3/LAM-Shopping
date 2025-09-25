@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                ➕ Create New Product
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">Add a new product with attributes (like frontend display)</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary"
           style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
           onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
            <i class="bi bi-arrow-left me-2"></i>Back to Products
        </a>
    </div>

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <!-- Basic Information Card -->
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-info-circle me-2" style="color: #3182ce !important;"></i>Basic Information
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="name" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                    Product Name <span style="color: #e53e3e !important;">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required
                                       style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                       placeholder="Enter product name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="sku" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                    SKU <span style="color: #e53e3e !important;">*</span>
                                </label>
                                <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku') }}" required
                                       style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                       placeholder="Product SKU">
                                @error('sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="slug" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                    URL Slug
                                </label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}"
                                       style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                       placeholder="product-url-slug">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="weight" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                    Weight (kg)
                                </label>
                                <input type="number" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight') }}" step="0.01" min="0"
                                       style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                       placeholder="0.00">
                                @error('weight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="short_description" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Short Description
                            </label>
                            <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description" name="short_description" rows="3"
                                      style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; line-height: 1.6 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important; resize: vertical !important;"
                                      placeholder="Brief product description for listings">{{ old('short_description') }}</textarea>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Full Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5"
                                      style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; line-height: 1.6 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important; resize: vertical !important;"
                                      placeholder="Detailed product description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dimensions -->
                        <div class="mb-3">
                            <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Dimensions (cm)
                            </label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="number" class="form-control @error('dimensions.length') is-invalid @enderror" name="dimensions[length]" value="{{ old('dimensions.length') }}" step="0.01" min="0"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                           placeholder="Length">
                                    <small style="color: #4a5568 !important; font-size: 12px !important;">Length</small>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" class="form-control @error('dimensions.width') is-invalid @enderror" name="dimensions[width]" value="{{ old('dimensions.width') }}" step="0.01" min="0"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                           placeholder="Width">
                                    <small style="color: #4a5568 !important; font-size: 12px !important;">Width</small>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" class="form-control @error('dimensions.height') is-invalid @enderror" name="dimensions[height]" value="{{ old('dimensions.height') }}" step="0.01" min="0"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                           placeholder="Height">
                                    <small style="color: #4a5568 !important; font-size: 12px !important;">Height</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Attributes Card (EXACTLY Like Frontend) -->
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-gear me-2" style="color: #3182ce !important;"></i>Product Attributes
                        </h5>
                        <small style="color: #4a5568 !important; font-size: 13px !important;">Configure specifications that will appear on frontend product detail page</small>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <!-- Product Attributes (Direct HTML Implementation) -->
                        <div id="product-attributes-container">
                            <!-- Color Attribute (EXACTLY like frontend lines 260-268) -->
                            <div class="mb-4">
                                <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 12px !important;">
                                    🎨 Color <span style="color: #e53e3e !important;">*</span>
                                </label>
                                <div class="color-selection" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; padding: 1.5rem !important; border-radius: 10px !important; border: 1px solid #e2e8f0 !important;">
                                    <div class="row">
                                        <div class="col-3 text-center mb-3">
                                            <div class="color-option" data-color="Black" style="width: 40px; height: 40px; background: #000000; border-radius: 50%; border: 2px solid #e2e8f0; cursor: pointer; transition: all 0.2s ease; margin: 0 auto;" onclick="selectColor(this, 'Black')"></div>
                                            <small style="color: #4a5568 !important; font-size: 11px !important; display: block; margin-top: 4px;">Black</small>
                                        </div>
                                        <div class="col-3 text-center mb-3">
                                            <div class="color-option" data-color="White" style="width: 40px; height: 40px; background: #ffffff; border-radius: 50%; border: 2px solid #e2e8f0; cursor: pointer; transition: all 0.2s ease; margin: 0 auto;" onclick="selectColor(this, 'White')"></div>
                                            <small style="color: #4a5568 !important; font-size: 11px !important; display: block; margin-top: 4px;">White</small>
                                        </div>
                                        <div class="col-3 text-center mb-3">
                                            <div class="color-option" data-color="Red" style="width: 40px; height: 40px; background: #ef4444; border-radius: 50%; border: 2px solid #e2e8f0; cursor: pointer; transition: all 0.2s ease; margin: 0 auto;" onclick="selectColor(this, 'Red')"></div>
                                            <small style="color: #4a5568 !important; font-size: 11px !important; display: block; margin-top: 4px;">Red</small>
                                        </div>
                                        <div class="col-3 text-center mb-3">
                                            <div class="color-option" data-color="Blue" style="width: 40px; height: 40px; background: #3b82f6; border-radius: 50%; border: 2px solid #e2e8f0; cursor: pointer; transition: all 0.2s ease; margin: 0 auto;" onclick="selectColor(this, 'Blue')"></div>
                                            <small style="color: #4a5568 !important; font-size: 11px !important; display: block; margin-top: 4px;">Blue</small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 text-center mb-3">
                                            <div class="color-option" data-color="Green" style="width: 40px; height: 40px; background: #10b981; border-radius: 50%; border: 2px solid #e2e8f0; cursor: pointer; transition: all 0.2s ease; margin: 0 auto;" onclick="selectColor(this, 'Green')"></div>
                                            <small style="color: #4a5568 !important; font-size: 11px !important; display: block; margin-top: 4px;">Green</small>
                                        </div>
                                        <div class="col-3 text-center mb-3">
                                            <div class="color-option" data-color="Yellow" style="width: 40px; height: 40px; background: #f59e0b; border-radius: 50%; border: 2px solid #e2e8f0; cursor: pointer; transition: all 0.2s ease; margin: 0 auto;" onclick="selectColor(this, 'Yellow')"></div>
                                            <small style="color: #4a5568 !important; font-size: 11px !important; display: block; margin-top: 4px;">Yellow</small>
                                        </div>
                                        <div class="col-3 text-center mb-3">
                                            <div class="color-option" data-color="Purple" style="width: 40px; height: 40px; background: #8b5cf6; border-radius: 50%; border: 2px solid #e2e8f0; cursor: pointer; transition: all 0.2s ease; margin: 0 auto;" onclick="selectColor(this, 'Purple')"></div>
                                            <small style="color: #4a5568 !important; font-size: 11px !important; display: block; margin-top: 4px;">Purple</small>
                                        </div>
                                        <div class="col-3 text-center mb-3">
                                            <div class="color-option" data-color="Pink" style="width: 40px; height: 40px; background: #ec4899; border-radius: 50%; border: 2px solid #e2e8f0; cursor: pointer; transition: all 0.2s ease; margin: 0 auto;" onclick="selectColor(this, 'Pink')"></div>
                                            <small style="color: #4a5568 !important; font-size: 11px !important; display: block; margin-top: 4px;">Pink</small>
                                        </div>
                                    </div>
                                    <input type="hidden" name="attribute_values[color]" id="selected_color" value="">
                                </div>
                            </div>

                            <!-- Size Attribute (EXACTLY like frontend lines 270-282) -->
                            <div class="mb-4">
                                <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 12px !important;">
                                    📏 Size <span style="color: #e53e3e !important;">*</span>
                                    <a href="#" class="ms-2" style="color: #3182ce !important; font-size: 12px !important; text-decoration: none !important;" data-bs-toggle="modal" data-bs-target="#sizeGuideModal">
                                        <i class="bi bi-info-circle"></i> Size Guide
                                    </a>
                                </label>
                                <div class="size-selection" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; padding: 1.5rem !important; border-radius: 10px !important; border: 1px solid #e2e8f0 !important;">
                                    <div class="row">
                                        <div class="col-2 text-center mb-2">
                                            <div class="size-option" data-size="XS" style="padding: 12px 8px; background: #ffffff; border: 2px solid #e2e8f0; border-radius: 8px; cursor: pointer; transition: all 0.2s ease; color: #1a202c; font-weight: 600; font-size: 14px;" onclick="selectSize(this, 'XS')">XS</div>
                                        </div>
                                        <div class="col-2 text-center mb-2">
                                            <div class="size-option" data-size="S" style="padding: 12px 8px; background: #ffffff; border: 2px solid #e2e8f0; border-radius: 8px; cursor: pointer; transition: all 0.2s ease; color: #1a202c; font-weight: 600; font-size: 14px;" onclick="selectSize(this, 'S')">S</div>
                                        </div>
                                        <div class="col-2 text-center mb-2">
                                            <div class="size-option" data-size="M" style="padding: 12px 8px; background: #ffffff; border: 2px solid #e2e8f0; border-radius: 8px; cursor: pointer; transition: all 0.2s ease; color: #1a202c; font-weight: 600; font-size: 14px;" onclick="selectSize(this, 'M')">M</div>
                                        </div>
                                        <div class="col-2 text-center mb-2">
                                            <div class="size-option" data-size="L" style="padding: 12px 8px; background: #ffffff; border: 2px solid #e2e8f0; border-radius: 8px; cursor: pointer; transition: all 0.2s ease; color: #1a202c; font-weight: 600; font-size: 14px;" onclick="selectSize(this, 'L')">L</div>
                                        </div>
                                        <div class="col-2 text-center mb-2">
                                            <div class="size-option" data-size="XL" style="padding: 12px 8px; background: #ffffff; border: 2px solid #e2e8f0; border-radius: 8px; cursor: pointer; transition: all 0.2s ease; color: #1a202c; font-weight: 600; font-size: 14px;" onclick="selectSize(this, 'XL')">XL</div>
                                        </div>
                                        <div class="col-2 text-center mb-2">
                                            <div class="size-option" data-size="XXL" style="padding: 12px 8px; background: #ffffff; border: 2px solid #e2e8f0; border-radius: 8px; cursor: pointer; transition: all 0.2s ease; color: #1a202c; font-weight: 600; font-size: 14px;" onclick="selectSize(this, 'XXL')">XXL</div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="attribute_values[size][]" id="selected_sizes" value="">
                                </div>
                            </div>

                            <!-- Material Attribute (Dropdown like frontend) -->
                            <div class="mb-4">
                                <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 12px !important;">
                                    🧵 Material
                                </label>
                                <select class="form-control" name="attribute_values[material]" onchange="updatePreview('material', this.value)"
                                        style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;">
                                    <option value="">Select Material</option>
                                    <option value="Cotton">Cotton</option>
                                    <option value="Polyester">Polyester</option>
                                    <option value="Wool">Wool</option>
                                    <option value="Silk">Silk</option>
                                    <option value="Leather">Leather</option>
                                    <option value="Denim">Denim</option>
                                </select>
                            </div>

                            <!-- Weight Attribute (Like frontend specifications) -->
                            <div class="mb-4">
                                <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 12px !important;">
                                    ⚖️ Weight
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="attribute_values[weight]" placeholder="e.g., 0.6kg"
                                           onchange="updatePreview('weight', this.value)"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;">
                                    <span class="input-group-text" style="background: #f8fafc !important; border: 2px solid #e2e8f0 !important; color: #4a5568 !important; font-weight: 600 !important;">kg</span>
                                </div>
                            </div>

                            <!-- Manufacturer Attribute (Like frontend specifications) -->
                            <div class="mb-4">
                                <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 12px !important;">
                                    🏭 Manufacturer
                                </label>
                                <input type="text" class="form-control" name="attribute_values[manufacturer]" placeholder="e.g., Nike, Adidas, etc."
                                       onchange="updatePreview('manufacturer', this.value)"
                                       style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;">
                            </div>
                        </div>

                        <!-- Preview Section -->
                        <div class="mt-4" style="padding: 1.5rem !important; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border-radius: 10px !important; border-left: 4px solid #8b5cf6 !important;">
                            <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 15px !important; margin-bottom: 1rem !important;">
                                <i class="bi bi-eye me-2" style="color: #8b5cf6 !important;"></i>Frontend Preview
                            </h6>
                            <p style="color: #2d3748 !important; font-size: 13px !important; margin-bottom: 12px !important;">Selected attributes will appear on your frontend product detail page like this:</p>
                            <div id="frontend-preview" style="background: #ffffff !important; padding: 1.5rem !important; border-radius: 8px !important; border: 1px solid #e9d5ff !important;">
                                <div class="row">
                                    <div class="col-6" style="color: #4a5568 !important; font-weight: 600 !important; font-size: 13px !important;">Color:</div>
                                    <div class="col-6" id="preview-color" style="color: #1a202c !important; font-size: 13px !important;">Not selected</div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6" style="color: #4a5568 !important; font-weight: 600 !important; font-size: 13px !important;">Size:</div>
                                    <div class="col-6" id="preview-size" style="color: #1a202c !important; font-size: 13px !important;">Not selected</div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6" style="color: #4a5568 !important; font-weight: 600 !important; font-size: 13px !important;">Weight:</div>
                                    <div class="col-6" id="preview-weight" style="color: #1a202c !important; font-size: 13px !important;">Not selected</div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6" style="color: #4a5568 !important; font-weight: 600 !important; font-size: 13px !important;">Manufacturer:</div>
                                    <div class="col-6" id="preview-manufacturer" style="color: #1a202c !important; font-size: 13px !important;">Not selected</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing Card -->
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-currency-dollar me-2" style="color: #3182ce !important;"></i>Pricing & Inventory
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="regular_price" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                    Regular Price <span style="color: #e53e3e !important;">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background: #f7fafc !important; border: 2px solid #e2e8f0 !important; color: #4a5568 !important;">$</span>
                                    <input type="number" class="form-control @error('regular_price') is-invalid @enderror" id="regular_price" name="regular_price" value="{{ old('regular_price') }}" step="0.01" min="0" required
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 0 10px 10px 0 !important; font-size: 15px !important; font-weight: 500 !important;"
                                           placeholder="0.00">
                                </div>
                                @error('regular_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="sale_price" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                    Sale Price
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background: #f7fafc !important; border: 2px solid #e2e8f0 !important; color: #4a5568 !important;">$</span>
                                    <input type="number" class="form-control @error('sale_price') is-invalid @enderror" id="sale_price" name="sale_price" value="{{ old('sale_price') }}" step="0.01" min="0"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 0 10px 10px 0 !important; font-size: 15px !important; font-weight: 500 !important;"
                                           placeholder="0.00">
                                </div>
                                @error('sale_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="quantity" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                    Stock Quantity <span style="color: #e53e3e !important;">*</span>
                                </label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', 0) }}" min="0" required
                                       style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;"
                                       placeholder="0">
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Images & Media Card -->
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-image me-2" style="color: #3182ce !important;"></i>Images & Media
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <div class="mb-3">
                            <label for="image" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Main Product Image
                            </label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*"
                                   style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                            <small style="color: #4a5568 !important; font-size: 12px !important;">Recommended: 800x800px, max 2MB</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="images" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Gallery Images
                            </label>
                            <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]" accept="image/*" multiple
                                   style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                            <small style="color: #4a5568 !important; font-size: 12px !important;">Select multiple images for product gallery</small>
                            @error('images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- SEO & Meta Card -->
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-search me-2" style="color: #3182ce !important;"></i>SEO & Meta Information
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <div class="mb-3">
                            <label for="meta_title" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Meta Title
                            </label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" value="{{ old('meta_title') }}" maxlength="255"
                                   style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                   placeholder="SEO title for search engines">
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="meta_description" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Meta Description
                            </label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="3" maxlength="500"
                                      style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; line-height: 1.6 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important; resize: vertical !important;"
                                      placeholder="SEO description for search engines">{{ old('meta_description') }}</textarea>
                            <small style="color: #4a5568 !important; font-size: 12px !important;">Recommended: 150-160 characters</small>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Categories & Brands Card -->
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-tags me-2" style="color: #3182ce !important;"></i>Organization
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <div class="mb-3">
                            <label for="category_id" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Category <span style="color: #e53e3e !important;">*</span>
                            </label>
                            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required
                                    style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="brand_id" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Brand <span style="color: #e53e3e !important;">*</span>
                            </label>
                            <select class="form-control @error('brand_id') is-invalid @enderror" id="brand_id" name="brand_id" required
                                    style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;">
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Status <span style="color: #e53e3e !important;">*</span>
                            </label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required
                                    style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;">
                                <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}
                                   style="width: 20px !important; height: 20px !important;">
                            <label class="form-check-label" for="featured" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-left: 10px !important;">
                                Featured Product
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-body" style="padding: 2rem !important;">
                        <div class="d-grid gap-2">
                            <button type="submit" name="action" value="save" class="btn btn-primary btn-lg" id="create-product-btn"
                                    style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: 2px solid #3182ce !important; color: #ffffff !important; padding: 16px 24px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 16px !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.background='linear-gradient(135deg, #2c5aa0 0%, #2a4a8a 100%) !important'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
                                    onmouseout="this.style.background='linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <i class="bi bi-check-circle me-2"></i>Create Product
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary"
                               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 14px 24px !important; border-radius: 10px !important; font-weight: 600 !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
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

<!-- Size Guide Modal (Like Frontend) -->
<div class="modal fade" id="sizeGuideModal" tabindex="-1" aria-labelledby="sizeGuideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 12px !important; border: 1px solid #e2e8f0 !important;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                <h5 class="modal-title" id="sizeGuideModalLabel" style="color: #1a202c !important; font-weight: 700 !important; font-size: 18px !important;">
                    <i class="bi bi-rulers me-2" style="color: #3182ce !important;"></i>Size Guide
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 2rem !important;">
                <div class="table-responsive">
                    <table class="table table-striped" style="margin-bottom: 0 !important;">
                        <thead style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;">
                            <tr>
                                <th style="color: #1a202c !important; font-weight: 600 !important; padding: 12px !important;">Size</th>
                                <th style="color: #1a202c !important; font-weight: 600 !important; padding: 12px !important;">Chest (cm)</th>
                                <th style="color: #1a202c !important; font-weight: 600 !important; padding: 12px !important;">Waist (cm)</th>
                                <th style="color: #1a202c !important; font-weight: 600 !important; padding: 12px !important;">Hip (cm)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td style="color: #2d3748 !important; padding: 10px 12px !important;">XS</td><td style="color: #4a5568 !important; padding: 10px 12px !important;">86-89</td><td style="color: #4a5568 !important; padding: 10px 12px !important;">66-69</td><td style="color: #4a5568 !important; padding: 10px 12px !important;">92-95</td></tr>
                            <tr><td style="color: #2d3748 !important; padding: 10px 12px !important;">S</td><td style="color: #4a5568 !important; padding: 10px 12px !important;">90-93</td><td style="color: #4a5568 !important; padding: 10px 12px !important;">70-73</td><td style="color: #4a5568 !important; padding: 10px 12px !important;">96-99</td></tr>
                            <tr><td style="color: #2d3748 !important; padding: 10px 12px !important;">M</td><td style="color: #4a5568 !important; padding: 10px 12px !important;">94-97</td><td style="color: #4a5568 !important; padding: 10px 12px !important;">74-77</td><td style="color: #4a5568 !important; padding: 10px 12px !important;">100-103</td></tr>
                            <tr><td style="color: #2d3748 !important; padding: 10px 12px !important;">L</td><td style="color: #4a5568 !important; padding: 10px 12px !important;">98-101</td><td style="color: #4a5568 !important; padding: 10px 12px !important;">78-81</td><td style="color: #4a5568 !important; padding: 10px 12px !important;">104-107</td></tr>
                            <tr><td style="color: #2d3748 !important; padding: 10px 12px !important;">XL</td><td style="color: #4a5568 !important; padding: 10px 12px !important;">102-105</td><td style="color: #4a5568 !important; padding: 10px 12px !important;">82-85</td><td style="color: #4a5568 !important; padding: 10px 12px !important;">108-111</td></tr>
                            <tr><td style="color: #2d3748 !important; padding: 10px 12px !important;">XXL</td><td style="color: #4a5568 !important; padding: 10px 12px !important;">106-109</td><td style="color: #4a5568 !important; padding: 10px 12px !important;">86-89</td><td style="color: #4a5568 !important; padding: 10px 12px !important;">112-115</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Size Guide Modal (Like Frontend) -->
<div class="modal fade" id="sizeGuideModal" tabindex="-1" aria-labelledby="sizeGuideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 12px !important; border: none !important; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f8fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important;">
                <h5 class="modal-title" id="sizeGuideModalLabel" style="color: #1a202c !important; font-weight: 700 !important; font-size: 18px !important;">
                    <i class="bi bi-rulers me-2" style="color: #3182ce !important;"></i>Size Guide
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background: none !important; border: none !important; font-size: 20px !important; color: #718096 !important;"></button>
            </div>
            <div class="modal-body" style="padding: 2rem !important;">
                <p style="color: #4a5568 !important; font-size: 14px !important; margin-bottom: 1.5rem !important;">
                    Use this guide to help customers choose the right size for your products.
                </p>
                <div class="table-responsive">
                    <table class="table table-striped table-sm" style="border-radius: 8px !important; overflow: hidden !important;">
                        <thead style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important;">
                            <tr>
                                <th style="color: #1a202c !important; font-weight: 700 !important; font-size: 13px !important; padding: 12px !important;">US Sizes</th>
                                <th style="color: #1a202c !important; font-weight: 700 !important; font-size: 13px !important; padding: 12px !important;">XS</th>
                                <th style="color: #1a202c !important; font-weight: 700 !important; font-size: 13px !important; padding: 12px !important;">S</th>
                                <th style="color: #1a202c !important; font-weight: 700 !important; font-size: 13px !important; padding: 12px !important;">M</th>
                                <th style="color: #1a202c !important; font-weight: 700 !important; font-size: 13px !important; padding: 12px !important;">L</th>
                                <th style="color: #1a202c !important; font-weight: 700 !important; font-size: 13px !important; padding: 12px !important;">XL</th>
                                <th style="color: #1a202c !important; font-weight: 700 !important; font-size: 13px !important; padding: 12px !important;">XXL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 12px !important; padding: 10px 12px !important;">Chest (inches)</td>
                                <td style="color: #1a202c !important; font-size: 12px !important; padding: 10px 12px !important;">32-34</td>
                                <td style="color: #1a202c !important; font-size: 12px !important; padding: 10px 12px !important;">34-36</td>
                                <td style="color: #1a202c !important; font-size: 12px !important; padding: 10px 12px !important;">36-38</td>
                                <td style="color: #1a202c !important; font-size: 12px !important; padding: 10px 12px !important;">38-40</td>
                                <td style="color: #1a202c !important; font-size: 12px !important; padding: 10px 12px !important;">40-42</td>
                                <td style="color: #1a202c !important; font-size: 12px !important; padding: 10px 12px !important;">42-44</td>
                            </tr>
                            <tr>
                                <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 12px !important; padding: 10px 12px !important;">Waist (inches)</td>
                                <td style="color: #1a202c !important; font-size: 12px !important; padding: 10px 12px !important;">26-28</td>
                                <td style="color: #1a202c !important; font-size: 12px !important; padding: 10px 12px !important;">28-30</td>
                                <td style="color: #1a202c !important; font-size: 12px !important; padding: 10px 12px !important;">30-32</td>
                                <td style="color: #1a202c !important; font-size: 12px !important; padding: 10px 12px !important;">32-34</td>
                                <td style="color: #1a202c !important; font-size: 12px !important; padding: 10px 12px !important;">34-36</td>
                                <td style="color: #1a202c !important; font-size: 12px !important; padding: 10px 12px !important;">36-38</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Debug form submission
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('create-product-btn');

    console.log('Form found:', form);
    console.log('Submit button found:', submitBtn);

    // Add click event listener to button
    if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            console.log('Create Product button clicked!');

            // Prevent multiple submissions
            if (this.disabled) {
                e.preventDefault();
                return false;
            }

            // Check if all required fields are filled
            const requiredFields = form.querySelectorAll('[required]');
            let allFieldsValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    console.log('Required field empty:', field.name);
                    allFieldsValid = false;
                    field.style.borderColor = '#e53e3e';
                } else {
                    field.style.borderColor = '#e2e8f0';
                }
            });

            if (!allFieldsValid) {
                e.preventDefault();
                alert('Please fill in all required fields (marked with *)');
                return false;
            }

            console.log('All fields valid, submitting form...');
            // Add loading state and disable button
            this.disabled = true;
            this.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Creating Product...';

            // Submit the form
            form.submit();
        });
    }

    // Auto-generate slug from name
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');

    if (nameInput && slugInput) {
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
    }

    // Attributes are now loaded directly in HTML
});

// Attributes are now loaded directly in HTML - no need for dynamic loading

// Color selection function (EXACTLY like frontend)
function selectColor(element, color) {
    // Remove active state from all colors
    document.querySelectorAll('.color-option').forEach(option => {
        option.style.borderColor = '#e2e8f0';
        option.style.transform = 'scale(1)';
        option.style.boxShadow = 'none';
        option.classList.remove('active');
    });

    // Add active state to selected color (like frontend)
    element.style.borderColor = '#3182ce !important';
    element.style.transform = 'scale(1.1) !important';
    element.style.boxShadow = '0 4px 8px rgba(49, 130, 206, 0.25) !important';
    element.classList.add('active');

    // Set hidden input value
    document.getElementById('selected_color').value = color;

    // Update frontend preview
    updatePreview('color', color);

    console.log('Selected color (like frontend):', color);
}

// Size selection function (EXACTLY like frontend multiple selection)
let selectedSizes = [];
function selectSize(element, size) {
    if (selectedSizes.includes(size)) {
        // Remove size (like frontend deselection)
        selectedSizes = selectedSizes.filter(s => s !== size);
        element.style.borderColor = '#e2e8f0';
        element.style.backgroundColor = '#ffffff';
        element.style.color = '#1a202c';
        element.classList.remove('active');
    } else {
        // Add size (like frontend selection)
        selectedSizes.push(size);
        element.style.borderColor = '#3182ce !important';
        element.style.backgroundColor = '#3182ce !important';
        element.style.color = '#ffffff !important';
        element.classList.add('active');
    }

    // Update hidden input
    document.getElementById('selected_sizes').value = selectedSizes.join(',');

    // Update frontend preview
    updatePreview('size', selectedSizes.join(', '));

    console.log('Selected sizes (like frontend):', selectedSizes);
}

// Update frontend preview (like your product detail page)
function updatePreview(attribute, value) {
    const previewElement = document.getElementById('preview-' + attribute);
    if (previewElement) {
        previewElement.textContent = value || 'Not selected';
        previewElement.style.color = value ? '#10b981' : '#718096';
        previewElement.style.fontWeight = value ? '600' : '400';
    }
}
</script>
@endpush

@push('styles')
<style>
    /* CLEAN PRODUCT CREATE PAGE - Professional Styling with Attributes */
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

    /* Color and Size Options (Like Frontend) */
    .color-option:hover {
        transform: scale(1.1) !important;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15) !important;
    }

    .size-option:hover {
        border-color: #3182ce !important;
        background-color: #f0f9ff !important;
        transform: translateY(-1px) !important;
    }

    .form-check-input:checked {
        background-color: #3182ce !important;
        border-color: #3182ce !important;
        box-shadow: 0 0 0 2px rgba(49, 130, 206, 0.2) !important;
    }

    .input-group-text {
        border-left: 2px solid #e2e8f0 !important;
        border-top: 2px solid #e2e8f0 !important;
        border-bottom: 2px solid #e2e8f0 !important;
        border-radius: 10px 0 0 10px !important;
    }

    /* Professional Modal Styling */
    .modal-content {
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15) !important;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8fafc !important;
    }
</style>
@endpush
@endsection
