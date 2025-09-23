@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                🔧 {{ $attribute->name }}
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                {{ ucfirst($attribute->type) }} attribute • {{ $attribute->is_required ? 'Required' : 'Optional' }} • Created {{ $attribute->created_at->format('M d, Y') }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.attributes.edit', $attribute) }}" class="btn btn-outline-primary" 
               style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                <i class="bi bi-pencil me-2"></i>Edit Attribute
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
            <!-- Attribute Information Card -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 700 !important; font-size: 18px !important;">
                        <i class="bi bi-info-circle me-2" style="color: #3182ce !important;"></i>Basic Information
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="attribute-type-display text-center" style="padding: 2rem !important; background: linear-gradient(135deg, {{ $attribute->type === 'text' ? '#f0f9ff, #e0f2fe' : ($attribute->type === 'select' ? '#ecfdf5, #d1fae5' : ($attribute->type === 'checkbox' ? '#fef3c7, #fed7aa' : '#f3e8ff, #e9d5ff')) }}) !important; border-radius: 12px !important; border: 1px solid #e2e8f0 !important;">
                                <div class="type-icon" style="background: {{ $attribute->type === 'text' ? '#3182ce' : ($attribute->type === 'select' ? '#10b981' : ($attribute->type === 'checkbox' ? '#f59e0b' : '#8b5cf6')) }} !important; width: 60px !important; height: 60px !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important; margin: 0 auto 15px auto !important;">
                                    <i class="bi bi-{{ $attribute->type === 'text' ? 'input-cursor-text' : ($attribute->type === 'select' ? 'list-ul' : ($attribute->type === 'checkbox' ? 'check-square' : 'circle')) }}" style="color: #ffffff !important; font-size: 24px !important;"></i>
                                </div>
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 8px !important;">{{ ucfirst($attribute->type) }}</h6>
                                <span class="badge" style="background-color: {{ $attribute->type === 'text' ? '#3182ce' : ($attribute->type === 'select' ? '#10b981' : ($attribute->type === 'checkbox' ? '#f59e0b' : '#8b5cf6')) }} !important; color: #ffffff !important; font-size: 11px !important; padding: 6px 12px !important; border-radius: 20px !important; text-transform: uppercase !important;">
                                    {{ $attribute->type }} TYPE
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table table-borderless" style="margin-bottom: 0 !important;">
                                    <tr>
                                        <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.75rem 0 !important; width: 140px !important;">Name:</td>
                                        <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">{{ $attribute->name }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">URL Slug:</td>
                                        <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">
                                            <code style="background: #f7fafc !important; color: #3182ce !important; padding: 4px 8px !important; border-radius: 4px !important; font-size: 13px !important;">{{ $attribute->slug }}</code>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">Type:</td>
                                        <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">
                                            <span class="badge" style="background-color: {{ $attribute->type === 'text' ? '#3182ce' : ($attribute->type === 'select' ? '#10b981' : ($attribute->type === 'checkbox' ? '#f59e0b' : '#8b5cf6')) }} !important; color: #ffffff !important; font-size: 12px !important; padding: 6px 12px !important; border-radius: 20px !important; font-weight: 600 !important;">
                                                {{ ucfirst($attribute->type) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">Required:</td>
                                        <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">
                                            <span class="badge" style="background-color: {{ $attribute->is_required ? '#e53e3e' : '#10b981' }} !important; color: #ffffff !important; font-size: 12px !important; padding: 6px 12px !important; border-radius: 20px !important;">
                                                {{ $attribute->is_required ? 'Required' : 'Optional' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">Values:</td>
                                        <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">{{ $attribute->attributeValues()->count() }} values</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">Created:</td>
                                        <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">{{ $attribute->created_at->format('M d, Y \a\t g:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">Updated:</td>
                                        <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">{{ $attribute->updated_at->format('M d, Y \a\t g:i A') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attribute Values Card -->
            @if($attribute->attributeValues->count() > 0)
                <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 700 !important; font-size: 18px !important;">
                            <i class="bi bi-list me-2" style="color: #3182ce !important;"></i>Attribute Values ({{ $attribute->attributeValues->count() }})
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        @if($attribute->type === 'text')
                            <div class="text-center py-4" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 10px !important; border: 1px solid #e0f2fe !important;">
                                <i class="bi bi-input-cursor-text" style="color: #3182ce !important; font-size: 3rem !important; margin-bottom: 1rem !important;"></i>
                                <h6 style="color: #1a202c !important; font-weight: 600 !important;">Text Input Attribute</h6>
                                <p style="color: #4a5568 !important; font-size: 14px !important; margin-bottom: 0 !important;">This attribute accepts free text input from users</p>
                            </div>
                        @else
                            <div class="row">
                                @foreach($attribute->attributeValues->take(12) as $value)
                                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                        <div class="value-item" 
                                             style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; padding: 1rem !important; border-radius: 10px !important; border: 1px solid #e2e8f0 !important; text-align: center !important; transition: all 0.2s ease !important;"
                                             onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(49, 130, 206, 0.1) !important'; this.style.borderColor='#3182ce !important';"
                                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.borderColor='#e2e8f0 !important';">
                                            
                                            @if($attribute->name === 'Color' && in_array(strtolower($value->value), ['red', 'blue', 'green', 'black', 'white', 'yellow', 'pink', 'purple', 'orange', 'brown', 'gray']))
                                                <!-- Color Display -->
                                                <div class="color-swatch" style="width: 30px !important; height: 30px !important; border-radius: 50% !important; background-color: {{ strtolower($value->value) === 'black' ? '#000000' : (strtolower($value->value) === 'white' ? '#ffffff' : strtolower($value->value)) }} !important; border: 2px solid #e2e8f0 !important; margin: 0 auto 8px auto !important; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;"></div>
                                            @else
                                                <!-- Regular Value Display -->
                                                <i class="bi bi-{{ $attribute->type === 'select' ? 'list-ul' : ($attribute->type === 'checkbox' ? 'check-square' : 'circle') }}" style="color: {{ $attribute->type === 'select' ? '#10b981' : ($attribute->type === 'checkbox' ? '#f59e0b' : '#8b5cf6') }} !important; font-size: 20px !important; margin-bottom: 8px !important;"></i>
                                            @endif
                                            
                                            <div class="value-text" style="color: #1a202c !important; font-weight: 600 !important; font-size: 13px !important;">
                                                {{ $value->value }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if($attribute->attributeValues->count() > 12)
                                <div class="text-center mt-3">
                                    <a href="{{ route('admin.attributes.values', $attribute) }}" class="btn btn-outline-primary"
                                       style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 10px 20px !important; border-radius: 8px !important; font-weight: 600 !important; font-size: 13px !important; text-decoration: none !important;"
                                       onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                                       onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                                        View All {{ $attribute->attributeValues->count() }} Values
                                    </a>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endif

            <!-- Statistics Card -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 700 !important; font-size: 18px !important;">
                        <i class="bi bi-bar-chart me-2" style="color: #3182ce !important;"></i>Statistics
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="row text-center">
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="stat-card" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; padding: 1.5rem !important; border-radius: 12px !important; border: 1px solid #e0f2fe !important; transition: all 0.2s ease !important;"
                                 onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(49, 130, 206, 0.15) !important';"
                                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <div class="stat-number" style="color: #1a202c !important; font-weight: 700 !important; font-size: 28px !important; line-height: 1 !important;">
                                    {{ $connectionCounts['values_count'] }}
                                </div>
                                <div class="stat-label" style="color: #4a5568 !important; font-size: 13px !important; font-weight: 600 !important; text-transform: uppercase !important; letter-spacing: 0.5px !important; margin-top: 8px !important;">Values</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="stat-card" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important; padding: 1.5rem !important; border-radius: 12px !important; border: 1px solid #d1fae5 !important; transition: all 0.2s ease !important;"
                                 onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(16, 185, 129, 0.15) !important';"
                                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <div class="stat-number" style="color: #1a202c !important; font-weight: 700 !important; font-size: 28px !important; line-height: 1 !important;">
                                    {{ $connectionCounts['products_count'] }}
                                </div>
                                <div class="stat-label" style="color: #4a5568 !important; font-size: 13px !important; font-weight: 600 !important; text-transform: uppercase !important; letter-spacing: 0.5px !important; margin-top: 8px !important;">Products</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="stat-card" style="background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; padding: 1.5rem !important; border-radius: 12px !important; border: 1px solid #fed7aa !important; transition: all 0.2s ease !important;"
                                 onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(245, 158, 11, 0.15) !important';"
                                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <div class="stat-number" style="color: #1a202c !important; font-weight: 700 !important; font-size: 28px !important; line-height: 1 !important;">
                                    {{ $connectionCounts['contacts_count'] }}
                                </div>
                                <div class="stat-label" style="color: #4a5568 !important; font-size: 13px !important; font-weight: 600 !important; text-transform: uppercase !important; letter-spacing: 0.5px !important; margin-top: 8px !important;">Contacts</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="stat-card" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; padding: 1.5rem !important; border-radius: 12px !important; border: 1px solid #e9d5ff !important; transition: all 0.2s ease !important;"
                                 onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(139, 92, 246, 0.15) !important';"
                                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <div class="stat-number" style="color: #1a202c !important; font-weight: 700 !important; font-size: 28px !important; line-height: 1 !important;">
                                    {{ $attribute->is_required ? 'YES' : 'NO' }}
                                </div>
                                <div class="stat-label" style="color: #4a5568 !important; font-size: 13px !important; font-weight: 600 !important; text-transform: uppercase !important; letter-spacing: 0.5px !important; margin-top: 8px !important;">Required</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions Card -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 700 !important; font-size: 18px !important;">
                        <i class="bi bi-lightning me-2" style="color: #3182ce !important;"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.attributes.values', $attribute) }}" class="btn btn-outline-primary w-100"
                           style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                           onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                            <i class="bi bi-list me-2"></i>Manage Values ({{ $connectionCounts['values_count'] }})
                        </a>
                        
                        <a href="{{ route('admin.attributes.products', $attribute) }}" class="btn btn-outline-success w-100"
                           style="color: #10b981 !important; border-color: #10b981 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                           onmouseover="this.style.backgroundColor='#10b981 !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#10b981 !important';">
                            <i class="bi bi-box me-2"></i>Products ({{ $connectionCounts['products_count'] }})
                        </a>
                        
                        <a href="{{ route('admin.attributes.contacts', $attribute) }}" class="btn btn-outline-warning w-100"
                           style="color: #f59e0b !important; border-color: #f59e0b !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                           onmouseover="this.style.backgroundColor='#f59e0b !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#f59e0b !important';">
                            <i class="bi bi-envelope me-2"></i>Contacts ({{ $connectionCounts['contacts_count'] }})
                        </a>
                        
                        <a href="{{ route('admin.attributes.analytics', $attribute) }}" class="btn btn-outline-info w-100"
                           style="color: #0891b2 !important; border-color: #0891b2 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                           onmouseover="this.style.backgroundColor='#0891b2 !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#0891b2 !important';">
                            <i class="bi bi-graph-up me-2"></i>Analytics
                        </a>
                    </div>
                </div>
            </div>

            <!-- Attribute Actions Card -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 700 !important; font-size: 18px !important;">
                        <i class="bi bi-gear me-2" style="color: #3182ce !important;"></i>Attribute Actions
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.attributes.edit', $attribute) }}" class="btn btn-outline-primary w-100"
                           style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                           onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                            <i class="bi bi-pencil me-2"></i>Edit Attribute
                        </a>
                        
                        <form method="POST" action="{{ route('admin.attributes.destroy', $attribute) }}" 
                              onsubmit="return confirm('Are you sure you want to delete this attribute? This action cannot be undone.')" 
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100"
                                    style="color: #e53e3e !important; border-color: #e53e3e !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.backgroundColor='#e53e3e !important'; this.style.color='#ffffff !important';"
                                    onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#e53e3e !important';">
                                <i class="bi bi-trash me-2"></i>Delete Attribute
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* CLEAN ATTRIBUTES SHOW PAGE - Professional Styling */
    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .value-item {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .attribute-type-display {
        transition: all 0.2s ease !important;
    }
    
    .attribute-type-display:hover .type-icon {
        transform: scale(1.1) !important;
    }
    
    .color-swatch {
        transition: all 0.2s ease !important;
    }
    
    .value-item:hover .color-swatch {
        transform: scale(1.2) !important;
    }
    
    .table-borderless td {
        border: none !important;
        vertical-align: middle !important;
    }
    
    .btn {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .btn:hover {
        transform: translateY(-1px) !important;
    }
    
    @media (max-width: 768px) {
        .stat-card {
            margin-bottom: 1rem !important;
        }
        
        .value-item {
            margin-bottom: 1rem !important;
        }
        
        .d-grid {
            gap: 0.75rem !important;
        }
    }
</style>
@endpush
@endsection
