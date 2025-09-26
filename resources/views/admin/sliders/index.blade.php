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

        <!-- Sliders Display -->
        <div class="row">
            @foreach($sliders as $slider)
                <div class="col-lg-6 col-md-12 mb-4">
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

                            <!-- Order Badge -->
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge" style="background: #1a202c !important; color: #ffffff !important; font-size: 10px !important; padding: 4px 8px !important; border-radius: 12px !important;">
                                    Order: {{ $slider->order }}
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
                                        ID: {{ $slider->id }} • Duration: {{ $slider->duration }}
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
                                <a href="{{ route('admin.sliders.show', $slider) }}" class="btn btn-sm btn-outline-info flex-fill"
                                   style="color: #0891b2 !important; border-color: #0891b2 !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                                   onmouseover="this.style.backgroundColor='#0891b2 !important'; this.style.color='#ffffff !important';"
                                   onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#0891b2 !important';">
                                    <i class="bi bi-eye"></i>
                                </a>
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
</div>

@push('scripts')
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
    }
</style>
@endpush
@endsection
