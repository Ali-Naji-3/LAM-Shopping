@extends('admin.dashboard')

@section('content')

<script>
// Global search functions for sliders
window.handleSliderSearchKeyup = function(input) {
    const searchTerm = input.value.trim();
    const minSearchLength = 2;

    // Force clean professional styling
    input.style.background = '#ffffff';
    input.style.color = '#1a202c';
    input.style.border = '2px solid #e2e8f0';

    if (searchTerm.length >= minSearchLength) {
        input.style.borderColor = '#3182ce';
        input.style.boxShadow = '0 0 0 4px rgba(49, 130, 206, 0.15)';
        input.style.transform = 'translateY(-1px)';
    } else {
        input.style.borderColor = '#e2e8f0';
        input.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
        input.style.transform = 'translateY(0)';
    }

    clearTimeout(window.sliderSearchTimeout);
    if (searchTerm.length >= minSearchLength || searchTerm.length === 0) {
        window.sliderSearchTimeout = setTimeout(function() {
            if (searchTerm !== '{{ request('search') }}') {
                input.closest('form').submit();
            }
        }, 600);
    }
};

window.handleSliderSearchKeydown = function(event, input) {
    if (event.key === 'Enter') {
        event.preventDefault();
        input.closest('form').submit();
    }
    if (event.key === 'Escape') {
        input.value = '';
        input.style.borderColor = '#e2e8f0';
        input.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
        input.blur();
    }
};

window.handleSliderSearchFocus = function(input) {
    input.style.borderColor = '#3182ce';
    input.style.boxShadow = '0 0 0 2px rgba(49, 130, 206, 0.2)';
};

window.handleSliderSearchBlur = function(input) {
    setTimeout(function() {
        if (input.value.trim().length === 0) {
            input.style.borderColor = '#e2e8f0';
            input.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
        }
    }, 150);
};
</script>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                🖼️ Sliders Management
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                Manage website sliders and banners • {{ $sliders->total() }} total sliders
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary"
               style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
               onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <i class="bi bi-plus-circle me-2"></i>Add Slider
            </a>
            <a href="{{ route('admin.sliders.analytics') }}" class="btn btn-outline-info"
               style="color: #0891b2 !important; border-color: #0891b2 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#0891b2 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#0891b2 !important';">
                <i class="bi bi-bar-chart me-2"></i>Analytics
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-collection mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Total</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($statistics['total_sliders']) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-check-circle mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Active</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($statistics['active_sliders']) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #3182ce 0%, #1e40af 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-calendar-plus mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Scheduled</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($statistics['scheduled_sliders']) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-calendar-x mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Expired</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($statistics['expired_sliders']) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-x-circle mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Inactive</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($statistics['inactive_sliders']) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Card -->
    <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-body" style="padding: 1.5rem 2rem !important;">
            <form method="GET" action="{{ route('admin.sliders.index') }}">
                <div class="row align-items-end">
                    <div class="col-md-6">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Search Sliders</label>
                        <div class="search-input-container" style="position: relative;">
                            <input type="text"
                                   name="search"
                                   id="search-sliders"
                                   class="form-control"
                                   placeholder="🔍 Search by title, subtitle, button text..."
                                   value="{{ request('search') }}"
                                   style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px 14px 45px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                   onkeyup="handleSliderSearchKeyup(this)"
                                   onkeydown="handleSliderSearchKeydown(event, this)"
                                   onfocus="handleSliderSearchFocus(this)"
                                   onblur="handleSliderSearchBlur(this)"
                                   autocomplete="off">
                            <i class="bi bi-search search-icon"
                               style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #718096 !important; opacity: 0.8; pointer-events: none; z-index: 10; font-size: 16px;"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Filter by Status</label>
                        <select name="status" class="form-control" style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-outline-primary flex-fill"
                                    style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 14px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                                    onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                                <i class="bi bi-search me-1"></i> Search
                            </button>
                            @if(request()->hasAny(['search', 'status']))
                                <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary"
                                   style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 14px 16px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                                   onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
                                   onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($sliders->count() > 0)
        <!-- Bulk Actions Card -->
        <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
            <div class="card-body" style="padding: 1rem 2rem !important;">
                <form id="bulk-actions-form" method="POST" action="{{ route('admin.sliders.bulk') }}">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="select-all">
                                <label class="form-check-label" for="select-all" style="color: #2d3748 !important; font-weight: 500 !important; font-size: 14px !important;">
                                    Select All
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select name="action" class="form-control" style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 12px 16px !important; border-radius: 8px !important; font-size: 14px !important; font-weight: 500 !important;">
                                <option value="">Bulk Actions</option>
                                <option value="activate">Activate Selected</option>
                                <option value="deactivate">Deactivate Selected</option>
                                <option value="delete">Delete Selected</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-outline-warning"
                                    style="color: #d69e2e !important; border-color: #d69e2e !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 8px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important;"
                                    onclick="return confirm('Are you sure you want to perform this bulk action?')">
                                <i class="bi bi-lightning me-1"></i> Apply Action
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Drag & Drop Reorder Notice -->
        <div class="alert alert-info mb-4" style="background: linear-gradient(135deg, #e0f2fe 0%, #b3e5fc 100%) !important; border: 1px solid #81d4fa !important; border-radius: 10px !important; color: #0277bd !important;">
            <div class="d-flex align-items-center">
                <i class="bi bi-info-circle me-3" style="font-size: 1.5rem !important;"></i>
                <div>
                    <strong>💡 Pro Tip:</strong> Drag sliders to reorder them. Higher positioned sliders appear first on your website.
                    <button type="button" class="btn btn-sm btn-outline-primary ms-3" id="enable-reorder-btn" style="color: #0277bd !important; border-color: #0277bd !important;">
                        <i class="bi bi-arrow-up-down me-1"></i>Enable Reordering
                    </button>
                </div>
            </div>
        </div>

        <!-- Sliders Display -->
        <div class="row" id="sliders-container">
            @foreach($sliders as $slider)
                <div class="col-lg-6 col-md-12 mb-4 slider-item" data-slider-id="{{ $slider->id }}" data-order="{{ $slider->order }}">
                    <div class="slider-card"
                         style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; overflow: hidden !important; transition: all 0.2s ease !important; height: 100% !important;"
                         onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.1) !important'; this.style.borderColor='#3182ce !important';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.borderColor='#e2e8f0 !important';">

                        <!-- Slider Image -->
                        <div class="slider-image-container" style="position: relative; height: 200px; overflow: hidden; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
                            @if($slider->image)
                                <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}"
                                     style="width: 100%; height: 100%; object-fit: cover; transition: all 0.3s ease;"
                                     onmouseover="this.style.transform='scale(1.05)';"
                                     onmouseout="this.style.transform='scale(1)';">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <i class="bi bi-image" style="font-size: 3rem; color: #718096;"></i>
                                </div>
                            @endif

                            <!-- Status Badge -->
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge" style="background: {{ $slider->status_color }} !important; color: #ffffff !important; font-size: 11px !important; padding: 6px 12px !important; border-radius: 20px !important; text-transform: uppercase !important;">
                                    {{ $slider->status }}
                                </span>
                            </div>

                            <!-- Priority Badge -->
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge" style="background: {{ $slider->priority_color }} !important; color: #ffffff !important; font-size: 10px !important; padding: 4px 8px !important; border-radius: 12px !important;">
                                    {{ $slider->priority_label }}
                                </span>
                            </div>

                            <!-- Checkbox for bulk actions -->
                            <div class="position-absolute bottom-0 end-0 m-2">
                                <div class="form-check">
                                    <input class="form-check-input slider-checkbox" type="checkbox" value="{{ $slider->id }}" name="selected_sliders[]" style="background: rgba(255, 255, 255, 0.9); border: 2px solid #ffffff;">
                                </div>
                            </div>
                        </div>

                        <!-- Slider Content -->
                        <div style="padding: 1.5rem !important;">
                            <!-- Title and Subtitle -->
                            @if($slider->title)
                                <h5 style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important; margin-bottom: 8px !important; line-height: 1.3 !important;">
                                    {{ $slider->title }}
                                </h5>
                            @endif

                            @if($slider->subtitle)
                                <p style="color: #4a5568 !important; font-size: 14px !important; line-height: 1.5 !important; margin-bottom: 12px !important;">
                                    {{ $slider->subtitle }}
                                </p>
                            @endif

                            <!-- Slider Details -->
                            <div class="mb-3" style="padding: 12px !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 8px !important;">
                                <div class="row">
                                    @if($slider->link)
                                        <div class="col-6">
                                            <small style="color: #718096 !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important;">Link</small>
                                            <div style="color: #1a202c !important; font-weight: 500 !important; font-size: 12px !important;">{{ Str::limit($slider->link, 25) }}</div>
                                        </div>
                                    @endif
                                    @if($slider->button_text)
                                        <div class="col-6">
                                            <small style="color: #718096 !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important;">Button</small>
                                            <div style="color: #1a202c !important; font-weight: 500 !important; font-size: 12px !important;">{{ $slider->button_text }}</div>
                                        </div>
                                    @endif
                                </div>

                                @if($slider->start_date || $slider->end_date)
                                    <div class="row mt-2">
                                        @if($slider->start_date)
                                            <div class="col-6">
                                                <small style="color: #718096 !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important;">Start Date</small>
                                                <div style="color: #1a202c !important; font-weight: 500 !important; font-size: 12px !important;">{{ $slider->start_date->format('M d, Y') }}</div>
                                            </div>
                                        @endif
                                        @if($slider->end_date)
                                            <div class="col-6">
                                                <small style="color: #718096 !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important;">End Date</small>
                                                <div style="color: #1a202c !important; font-weight: 500 !important; font-size: 12px !important;">{{ $slider->end_date->format('M d, Y') }}</div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Slider Meta -->
                                <div class="mb-3" style="padding: 8px 12px !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 6px !important;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small style="color: #92400e !important; font-weight: 600 !important; font-size: 11px !important;">
                                        ID: {{ $slider->id }} • Priority: {{ $slider->priority_label }} • Order: {{ $slider->order }}
                                    </small>
                                    <small style="color: #92400e !important; font-weight: 600 !important; font-size: 11px !important;">
                                        {{ $slider->created_at->format('M d, Y') }}
                                    </small>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="d-flex gap-1">
                                <form method="POST" action="{{ route('admin.sliders.toggleStatus', $slider) }}" class="d-inline flex-fill">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $slider->is_active ? 'btn-outline-warning' : 'btn-outline-success' }} w-100"
                                            style="color: {{ $slider->is_active ? '#d69e2e' : '#10b981' }} !important; border-color: {{ $slider->is_active ? '#d69e2e' : '#10b981' }} !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important;"
                                            onmouseover="this.style.backgroundColor='{{ $slider->is_active ? '#d69e2e' : '#10b981' }} !important'; this.style.color='#ffffff !important';"
                                            onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='{{ $slider->is_active ? '#d69e2e' : '#10b981' }} !important';">
                                        <i class="bi bi-{{ $slider->is_active ? 'pause' : 'play' }}-circle"></i>
                                    </button>
                                </form>
                                <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-sm btn-outline-primary flex-fill"
                                   style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                                   onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                                   onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-info flex-fill" onclick="previewSlider({{ $slider->id }})"
                                   style="color: #0891b2 !important; border-color: #0891b2 !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important;"
                                   onmouseover="this.style.backgroundColor='#0891b2 !important'; this.style.color='#ffffff !important';"
                                   onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#0891b2 !important';">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.sliders.destroy', $slider) }}" class="d-inline flex-fill"
                                      onsubmit="return confirm('Are you sure you want to delete this slider?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100"
                                            style="color: #e53e3e !important; border-color: #e53e3e !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important;"
                                            onmouseover="this.style.backgroundColor='#e53e3e !important'; this.style.color='#ffffff !important';"
                                            onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#e53e3e !important';">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Professional Pagination -->
        <div class="pagination-container mt-4" style="background: white; padding: 12px 20px; border-radius: 8px; border: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <div class="pagination-info" style="color: #6c757d; font-weight: 400; font-size: 14px; white-space: nowrap;">
                Showing {{ $sliders->firstItem() ?? 0 }} to {{ $sliders->lastItem() ?? 0 }} of {{ $sliders->total() }} entries
            </div>
            <div class="pagination-links">
                {{ $sliders->appends(request()->query())->links('pagination.custom') }}
            </div>
        </div>

    @else
        <!-- Empty State -->
        <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
            <div class="card-body" style="padding: 3rem !important;">
                <div class="text-center">
                    <i class="bi bi-images" style="color: #718096 !important; font-size: 4rem !important; margin-bottom: 1.5rem !important;"></i>
                    <h4 style="color: #1a202c !important; font-weight: 600 !important; margin-bottom: 1rem !important;">No Sliders Found</h4>
                    <p style="color: #4a5568 !important; font-size: 16px !important; line-height: 1.6 !important; max-width: 500px !important; margin: 0 auto 2rem auto !important;">
                        @if(request()->hasAny(['search', 'status']))
                            No sliders match your current search criteria. Try adjusting your filters.
                        @else
                            Create your first slider to showcase featured content, promotions, or announcements on your website.
                        @endif
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary"
                           style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 24px !important; border-radius: 10px !important; font-weight: 600 !important;">
                            <i class="bi bi-plus-circle me-2"></i>Create First Slider
                        </a>
                        @if(request()->hasAny(['search', 'status']))
                            <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary"
                               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 24px !important; border-radius: 10px !important; font-weight: 600 !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                                <i class="bi bi-arrow-left me-2"></i>Clear Filters
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Live Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="border-radius: 12px !important; border: none !important;">
                <div class="modal-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important;">
                    <h5 class="modal-title" id="previewModalLabel" style="color: #1a202c !important; font-weight: 600 !important;">
                        <i class="bi bi-eye me-2" style="color: #3182ce !important;"></i>Live Preview
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 0 !important;">
                    <!-- Preview Content will be loaded here -->
                    <div id="preview-content" style="min-height: 400px; background: #f8fafc; display: flex; align-items: center; justify-content: center;">
                        <div class="text-center">
                            <i class="bi bi-image" style="font-size: 3rem; color: #718096; margin-bottom: 1rem;"></i>
                            <p style="color: #4a5568;">Loading preview...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f8fafc !important; border-top: 1px solid #e2e8f0 !important; border-radius: 0 0 12px 12px !important;">
                    <div class="d-flex justify-content-between w-100">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="switchPreviewMode('desktop')" id="desktop-preview">
                                <i class="bi bi-laptop me-1"></i>Desktop
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="switchPreviewMode('tablet')" id="tablet-preview">
                                <i class="bi bi-tablet me-1"></i>Tablet
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="switchPreviewMode('mobile')" id="mobile-preview">
                                <i class="bi bi-phone me-1"></i>Mobile
                            </button>
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>Close Preview
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bulk selection functionality
    const selectAllCheckbox = document.getElementById('select-all');
    const sliderCheckboxes = document.querySelectorAll('.slider-checkbox');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            sliderCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActionsState();
        });
    }

    sliderCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllState();
            updateBulkActionsState();
        });
    });

    function updateSelectAllState() {
        if (selectAllCheckbox) {
            const checkedCount = document.querySelectorAll('.slider-checkbox:checked').length;
            selectAllCheckbox.checked = checkedCount === sliderCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < sliderCheckboxes.length;
        }
    }

    function updateBulkActionsState() {
        const selectedCount = document.querySelectorAll('.slider-checkbox:checked').length;
        const bulkForm = document.getElementById('bulk-actions-form');

        if (bulkForm) {
            const actionSelect = bulkForm.querySelector('select[name="action"]');

            if (selectedCount > 0) {
                actionSelect.style.borderColor = '#3182ce';
                actionSelect.style.background = '#f0f9ff';
            } else {
                actionSelect.style.borderColor = '#e2e8f0';
                actionSelect.style.background = '#ffffff';
            }
        }
    }

    // Drag & Drop Reordering
    let sortableInstance = null;
    const enableReorderBtn = document.getElementById('enable-reorder-btn');
    const slidersContainer = document.getElementById('sliders-container');

    if (enableReorderBtn && slidersContainer) {
        enableReorderBtn.addEventListener('click', function() {
            if (!sortableInstance) {
                // Enable drag & drop
                sortableInstance = new Sortable(slidersContainer, {
                    animation: 150,
                    handle: '.slider-card',
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',
                    onEnd: function(evt) {
                        const sliderItems = document.querySelectorAll('.slider-item');
                        const sliderIds = Array.from(sliderItems).map(item => item.getAttribute('data-slider-id'));
                        
                        // Send reorder request
                        fetch('{{ route("admin.sliders.reorder") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                slider_ids: sliderIds
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                showNotification('Sliders reordered successfully!', 'success');
                            } else {
                                // Show error message
                                showNotification('Failed to reorder sliders', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('Failed to reorder sliders', 'error');
                        });
                    }
                });
                
                // Update button text and style
                enableReorderBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i>Reordering Enabled';
                enableReorderBtn.className = 'btn btn-sm btn-success ms-3';
                enableReorderBtn.style.color = '#ffffff !important';
                enableReorderBtn.style.borderColor = '#10b981 !important';
                enableReorderBtn.style.backgroundColor = '#10b981 !important';
                
                // Add visual indicators to slider cards
                document.querySelectorAll('.slider-card').forEach(card => {
                    card.style.cursor = 'move';
                    card.title = 'Drag to reorder';
                });
                
                showNotification('Drag & drop reordering enabled! Drag any slider to reorder.', 'info');
            }
        });
    }

    // Notification function
    function showNotification(message, type) {
        const alertClass = {
            'success': 'alert-success',
            'error': 'alert-danger',
            'info': 'alert-info'
        }[type] || 'alert-info';
        
        const notification = document.createElement('div');
        notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 5000);
    }

    // Preview functionality
    window.previewSlider = function(sliderId) {
        const modal = new bootstrap.Modal(document.getElementById('previewModal'));
        modal.show();
        
        // Load slider data and create preview
        loadSliderPreview(sliderId);
    };

    window.switchPreviewMode = function(mode) {
        const previewContent = document.getElementById('preview-content');
        const buttons = document.querySelectorAll('[id$="-preview"]');
        
        // Update button states
        buttons.forEach(btn => {
            btn.className = btn.className.replace('btn-outline-primary', 'btn-outline-secondary');
        });
        
        const activeBtn = document.getElementById(mode + '-preview');
        if (activeBtn) {
            activeBtn.className = activeBtn.className.replace('btn-outline-secondary', 'btn-outline-primary');
        }
        
        // Apply preview mode styles
        previewContent.className = 'preview-' + mode;
        
        // Update preview container width
        const container = previewContent.querySelector('.preview-container');
        if (container) {
            container.style.maxWidth = {
                'desktop': '100%',
                'tablet': '768px',
                'mobile': '375px'
            }[mode];
            container.style.margin = '0 auto';
        }
    };

    function loadSliderPreview(sliderId) {
        const previewContent = document.getElementById('preview-content');
        
        // Find slider data from the current page
        const sliderElement = document.querySelector(`[data-slider-id="${sliderId}"]`);
        if (!sliderElement) {
            previewContent.innerHTML = '<div class="text-center"><p style="color: #e53e3e;">Slider not found</p></div>';
            return;
        }
        
        // Extract slider data from the DOM
        const sliderData = extractSliderData(sliderElement);
        
        // Generate preview HTML
        const previewHTML = generateSliderPreviewHTML(sliderData);
        
        // Update preview content
        previewContent.innerHTML = previewHTML;
        
        // Set default to desktop view
        switchPreviewMode('desktop');
    }

    function extractSliderData(element) {
        const title = element.querySelector('h5')?.textContent?.trim() || '';
        const subtitle = element.querySelector('p')?.textContent?.trim() || '';
        const image = element.querySelector('img')?.src || '';
        const status = element.querySelector('.badge')?.textContent?.trim() || 'Active';
        
        // Try to extract link and button text from the slider data
        const linkElement = element.querySelector('[style*="Link"]');
        const buttonElement = element.querySelector('[style*="Button"]');
        
        const link = linkElement?.nextElementSibling?.textContent?.trim() || '';
        const buttonText = buttonElement?.nextElementSibling?.textContent?.trim() || '';
        
        return {
            title,
            subtitle,
            image,
            link,
            buttonText,
            status
        };
    }

    function generateSliderPreviewHTML(data) {
        return `
            <div class="preview-container" style="position: relative; width: 100%; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                <!-- Slider Preview -->
                <div class="slider-preview" style="position: relative; height: 400px; overflow: hidden; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    ${data.image ? `
                        <img src="${data.image}" alt="${data.title}" style="width: 100%; height: 100%; object-fit: cover;">
                    ` : `
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-image" style="font-size: 4rem; color: rgba(255,255,255,0.7);"></i>
                        </div>
                    `}
                    
                    <!-- Overlay Content -->
                    <div class="slider-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;">
                        <div class="slider-content" style="text-align: center; color: white; padding: 2rem; max-width: 600px;">
                            ${data.title ? `<h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">${data.title}</h2>` : ''}
                            ${data.subtitle ? `<p style="font-size: 1.2rem; margin-bottom: 2rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">${data.subtitle}</p>` : ''}
                            ${data.buttonText ? `
                                <a href="${data.link || '#'}" class="btn btn-primary btn-lg" style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%); border: none; padding: 12px 30px; border-radius: 25px; font-weight: 600; text-decoration: none; box-shadow: 0 4px 12px rgba(49, 130, 206, 0.3);">
                                    ${data.buttonText}
                                </a>
                            ` : ''}
                        </div>
                    </div>
                    
                    <!-- Status Badge -->
                    <div style="position: absolute; top: 20px; right: 20px;">
                        <span class="badge" style="background: ${getStatusColor(data.status)}; padding: 8px 16px; border-radius: 20px; font-weight: 600;">
                            ${data.status}
                        </span>
                    </div>
                </div>
                
                <!-- Preview Info -->
                <div style="padding: 1rem; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <small style="color: #718096; font-weight: 600;">SLIDER ID</small>
                            <div style="color: #1a202c; font-weight: 600;">#${sliderId}</div>
                        </div>
                        <div class="col-md-3">
                            <small style="color: #718096; font-weight: 600;">STATUS</small>
                            <div style="color: #1a202c; font-weight: 600;">${data.status}</div>
                        </div>
                        <div class="col-md-3">
                            <small style="color: #718096; font-weight: 600;">HAS LINK</small>
                            <div style="color: ${data.link ? '#10b981' : '#e53e3e'}; font-weight: 600;">
                                ${data.link ? 'Yes' : 'No'}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <small style="color: #718096; font-weight: 600;">BUTTON</small>
                            <div style="color: ${data.buttonText ? '#10b981' : '#e53e3e'}; font-weight: 600;">
                                ${data.buttonText ? data.buttonText : 'None'}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    function getStatusColor(status) {
        const colors = {
            'Active': '#10b981',
            'Scheduled': '#3182ce',
            'Expired': '#6b7280',
            'Inactive': '#ef4444'
        };
        return colors[status] || '#6b7280';
    }
});
</script>
@endpush

@push('styles')
<style>
    /* CLEAN SLIDERS INDEX - Professional Styling */
    .slider-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .slider-image-container img {
        transition: all 0.3s ease !important;
    }

    /* Clean Search Input Styling */
    #search-sliders::placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }

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

    .form-check-input:checked {
        background-color: #3182ce !important;
        border-color: #3182ce !important;
        box-shadow: 0 0 0 2px rgba(49, 130, 206, 0.2) !important;
    }

    /* Drag & Drop Styles */
    .sortable-ghost {
        opacity: 0.4 !important;
        background: #f0f9ff !important;
        border: 2px dashed #3182ce !important;
    }

    .sortable-chosen {
        transform: scale(1.02) !important;
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3) !important;
        border-color: #3182ce !important;
        z-index: 1000 !important;
    }

    .sortable-drag {
        transform: rotate(5deg) !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
    }

    .slider-item {
        transition: all 0.3s ease !important;
    }

    .slider-card:hover {
        cursor: move !important;
    }

    /* Notification Styles */
    .alert.position-fixed {
        animation: slideInRight 0.3s ease-out;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .slider-card {
            margin-bottom: 1rem !important;
        }

        .d-flex.gap-1 {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }

        .d-flex.gap-1 .btn {
            width: 100% !important;
        }

        .slider-image-container {
            height: 150px !important;
        }

        .alert.position-fixed {
            top: 10px !important;
            right: 10px !important;
            left: 10px !important;
            min-width: auto !important;
        }
    }
</style>
@endpush
@endsection
