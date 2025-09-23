@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                👁️ Slider Details
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                Slider #{{ $slider->id }} • Order: {{ $slider->order }} • Status: {{ $slider->status }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-outline-primary"
               style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                <i class="bi bi-pencil me-2"></i>Edit Slider
            </a>
            <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary" 
               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                <i class="bi bi-arrow-left me-2"></i>Back to Sliders
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Slider Preview -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-image me-2" style="color: #3182ce !important;"></i>Slider Preview
                        </h5>
                        <span class="badge" style="background: {{ $slider->status_color }} !important; color: #ffffff !important; font-size: 12px !important; padding: 6px 12px !important; border-radius: 20px !important; text-transform: uppercase !important;">
                            {{ $slider->status }}
                        </span>
                    </div>
                </div>
                <div class="card-body" style="padding: 0 !important;">
                    <div class="slider-display" style="position: relative; height: 300px; overflow: hidden; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
                        @if($slider->image)
                            <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            
                            <!-- Overlay Content -->
                            @if($slider->title || $slider->subtitle || $slider->button_text)
                                <div class="slider-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.1) 100%); display: flex; align-items: center; justify-content: center;">
                                    <div class="slider-content text-center" style="color: #ffffff; max-width: 600px; padding: 2rem;">
                                        @if($slider->title)
                                            <h2 style="color: #ffffff !important; font-weight: 700 !important; font-size: 2.5rem !important; margin-bottom: 1rem !important; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
                                                {{ $slider->title }}
                                            </h2>
                                        @endif
                                        @if($slider->subtitle)
                                            <p style="color: #ffffff !important; font-size: 1.2rem !important; margin-bottom: 1.5rem !important; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">
                                                {{ $slider->subtitle }}
                                            </p>
                                        @endif
                                        @if($slider->button_text)
                                            <div class="btn btn-primary btn-lg" style="background: #3182ce !important; border: none !important; color: #ffffff !important; padding: 12px 24px !important; border-radius: 8px !important; font-weight: 600 !important; pointer-events: none; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                                {{ $slider->button_text }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <div class="text-center">
                                    <i class="bi bi-image" style="font-size: 4rem; color: #718096; margin-bottom: 1rem;"></i>
                                    <h6 style="color: #4a5568; font-weight: 500;">No image uploaded</h6>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Slider Information -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-info-circle me-2" style="color: #3182ce !important;"></i>Slider Information
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.75rem 0 !important; width: 30%;">Title:</td>
                                <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">{{ $slider->title ?? 'No title' }}</td>
                            </tr>
                            <tr>
                                <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">Subtitle:</td>
                                <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">{{ $slider->subtitle ?? 'No subtitle' }}</td>
                            </tr>
                            <tr>
                                <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">Link:</td>
                                <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">
                                    @if($slider->link)
                                        <a href="{{ $slider->link }}" target="_blank" style="color: #3182ce !important; text-decoration: none !important;">
                                            {{ Str::limit($slider->link, 50) }} <i class="bi bi-box-arrow-up-right ms-1"></i>
                                        </a>
                                    @else
                                        No link
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">Button Text:</td>
                                <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">{{ $slider->button_text ?? 'No button text' }}</td>
                            </tr>
                            <tr>
                                <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">Display Order:</td>
                                <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">{{ $slider->order }}</td>
                            </tr>
                            <tr>
                                <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">Start Date:</td>
                                <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">{{ $slider->start_date ? $slider->start_date->format('F d, Y') : 'No start date (immediate)' }}</td>
                            </tr>
                            <tr>
                                <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">End Date:</td>
                                <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">{{ $slider->end_date ? $slider->end_date->format('F d, Y') : 'No end date (permanent)' }}</td>
                            </tr>
                            <tr>
                                <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">Duration:</td>
                                <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">{{ $slider->duration }}</td>
                            </tr>
                            <tr>
                                <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">Created:</td>
                                <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">{{ $slider->created_at->format('F d, Y \a\t g:i A') }}</td>
                            </tr>
                            <tr>
                                <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">Updated:</td>
                                <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.75rem 0 !important;">{{ $slider->updated_at->format('F d, Y \a\t g:i A') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-lightning me-2" style="color: #3182ce !important;"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-grid gap-2">
                        <form method="POST" action="{{ route('admin.sliders.toggleStatus', $slider) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn {{ $slider->is_active ? 'btn-warning' : 'btn-success' }} w-100"
                                    style="background: linear-gradient(135deg, {{ $slider->is_active ? '#f59e0b, #d97706' : '#10b981, #059669' }}) !important; border: none !important; color: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba({{ $slider->is_active ? '245, 158, 11' : '16, 185, 129' }}, 0.3) !important';"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <i class="bi bi-{{ $slider->is_active ? 'pause' : 'play' }}-circle me-2"></i>{{ $slider->is_active ? 'Deactivate' : 'Activate' }} Slider
                            </button>
                        </form>
                        
                        <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-outline-primary w-100"
                           style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; text-decoration: none !important;"
                           onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                            <i class="bi bi-pencil me-2"></i>Edit Slider
                        </a>
                        
                        @if($slider->link)
                            <a href="{{ $slider->link }}" target="_blank" class="btn btn-outline-info w-100"
                               style="color: #0891b2 !important; border-color: #0891b2 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#0891b2 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#0891b2 !important';">
                                <i class="bi bi-box-arrow-up-right me-2"></i>Visit Link
                            </a>
                        @endif
                        
                        <form method="POST" action="{{ route('admin.sliders.destroy', $slider) }}" onsubmit="return confirm('Are you sure you want to delete this slider?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100"
                                    style="color: #e53e3e !important; border-color: #e53e3e !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.backgroundColor='#e53e3e !important'; this.style.color='#ffffff !important';"
                                    onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#e53e3e !important';">
                                <i class="bi bi-trash me-2"></i>Delete Slider
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Slider Statistics -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-graph-up me-2" style="color: #3182ce !important;"></i>Slider Statistics
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="slider-stats">
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Slider ID</span>
                                <span style="color: #3182ce !important; font-weight: 700 !important; font-size: 14px !important;">#{{ $slider->id }}</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Status</span>
                                <span style="color: {{ $slider->status_color }} !important; font-weight: 700 !important; font-size: 14px !important;">{{ $slider->status }}</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Display Order</span>
                                <span style="color: #f59e0b !important; font-weight: 700 !important; font-size: 14px !important;">{{ $slider->order }}</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border-radius: 8px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Duration</span>
                                <span style="color: #8b5cf6 !important; font-weight: 700 !important; font-size: 14px !important;">{{ $slider->duration }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* CLEAN SLIDERS SHOW PAGE - Professional Styling */
    .slider-display img {
        transition: all 0.3s ease !important;
    }
    
    .slider-display:hover img {
        transform: scale(1.02) !important;
    }
    
    .slider-overlay {
        transition: all 0.3s ease !important;
    }
    
    .slider-display:hover .slider-overlay {
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.2) 100%) !important;
    }
    
    .stat-item {
        transition: all 0.2s ease !important;
    }
    
    .stat-item:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }
    
    .table td {
        border-bottom: 1px solid #f1f5f9 !important;
    }
    
    .table tr:last-child td {
        border-bottom: none !important;
    }
</style>
@endpush
@endsection
