@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                📊 Sliders Analytics
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                Comprehensive analytics and insights for your website sliders
            </p>
        </div>
        <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary" 
           style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
           onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
            <i class="bi bi-arrow-left me-2"></i>Back to Sliders
        </a>
    </div>

    <!-- Overview Statistics -->
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-collection mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Total Sliders</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($analytics['total_sliders']) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-check-circle mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Active</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($analytics['active_sliders']) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #3182ce 0%, #1e40af 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-calendar-plus mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Scheduled</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($analytics['scheduled_sliders']) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-calendar-x mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Expired</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($analytics['expired_sliders']) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-x-circle mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Inactive</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($analytics['inactive_sliders']) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-clock mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Avg Duration</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ $analytics['average_duration'] }} days</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Content Performance -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-graph-up me-2" style="color: #3182ce !important;"></i>Content Performance
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="performance-metric text-center" style="padding: 1.5rem !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 10px !important; border: 1px solid #e0f2fe !important;">
                                <h4 style="color: #3182ce !important; font-weight: 700 !important; font-size: 2rem !important; margin-bottom: 8px !important;">{{ number_format($analytics['sliders_with_links']) }}</h4>
                                <h6 style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 4px !important;">Sliders with Links</h6>
                                <small style="color: #4a5568 !important; font-size: 12px !important;">{{ $analytics['total_sliders'] > 0 ? round(($analytics['sliders_with_links'] / $analytics['total_sliders']) * 100, 1) : 0 }}% of total</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="performance-metric text-center" style="padding: 1.5rem !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 10px !important; border: 1px solid #dcfce7 !important;">
                                <h4 style="color: #10b981 !important; font-weight: 700 !important; font-size: 2rem !important; margin-bottom: 8px !important;">{{ number_format($analytics['sliders_with_buttons']) }}</h4>
                                <h6 style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 4px !important;">Sliders with Buttons</h6>
                                <small style="color: #4a5568 !important; font-size: 12px !important;">{{ $analytics['total_sliders'] > 0 ? round(($analytics['sliders_with_buttons'] / $analytics['total_sliders']) * 100, 1) : 0 }}% of total</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="performance-metric text-center" style="padding: 1.5rem !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 10px !important; border: 1px solid #fed7aa !important;">
                                <h4 style="color: #f59e0b !important; font-weight: 700 !important; font-size: 2rem !important; margin-bottom: 8px !important;">{{ $analytics['average_duration'] }}</h4>
                                <h6 style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 4px !important;">Avg Campaign Days</h6>
                                <small style="color: #4a5568 !important; font-size: 12px !important;">For time-limited sliders</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Sliders -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-clock-history me-2" style="color: #3182ce !important;"></i>Recent Sliders
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    @if($analytics['recent_sliders']->count() > 0)
                        <div class="recent-sliders">
                            @foreach($analytics['recent_sliders'] as $slider)
                                <div class="recent-slider-item" style="padding: 1rem !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 10px !important; margin-bottom: 1rem !important; border: 1px solid #e2e8f0 !important; transition: all 0.2s ease !important;"
                                     onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 2px 8px rgba(0, 0, 0, 0.1) !important';"
                                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 4px !important;">
                                                {{ $slider->title ?? 'Untitled Slider' }}
                                            </h6>
                                            <small style="color: #4a5568 !important; font-size: 12px !important;">
                                                Created {{ $slider->created_at->diffForHumans() }} • Order: {{ $slider->order }}
                                            </small>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge" style="background: {{ $slider->status_color }} !important; color: #ffffff !important; font-size: 10px !important; padding: 4px 8px !important; border-radius: 12px !important;">
                                                {{ $slider->status }}
                                            </span>
                                            <a href="{{ route('admin.sliders.show', $slider) }}" class="btn btn-sm btn-outline-primary"
                                               style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 4px 8px !important; border-radius: 4px !important; font-size: 11px !important; text-decoration: none !important;"
                                               onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-collection" style="color: #718096 !important; font-size: 3rem !important; margin-bottom: 1rem !important;"></i>
                            <h6 style="color: #4a5568 !important; font-weight: 500 !important;">No sliders created yet</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Upcoming Expirations -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-exclamation-triangle me-2" style="color: #f59e0b !important;"></i>Upcoming Expirations
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem !important;">
                    @if($analytics['upcoming_expirations']->count() > 0)
                        @foreach($analytics['upcoming_expirations'] as $expiring)
                            <div class="expiring-item" style="padding: 12px !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important; border-left: 4px solid #f59e0b !important;">
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 4px !important;">
                                    {{ $expiring->title ?? 'Untitled Slider' }}
                                </h6>
                                <small style="color: #92400e !important; font-size: 12px !important; font-weight: 600 !important;">
                                    Expires: {{ $expiring->end_date->format('M d, Y') }}
                                    ({{ $expiring->end_date->diffForHumans() }})
                                </small>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-check-circle" style="color: #10b981 !important; font-size: 2rem !important; margin-bottom: 8px !important;"></i>
                            <h6 style="color: #10b981 !important; font-weight: 600 !important; margin-bottom: 4px !important;">All Good!</h6>
                            <small style="color: #4a5568 !important; font-size: 12px !important;">No sliders expiring in the next 7 days</small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-lightning me-2" style="color: #3182ce !important;"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary w-100"
                           style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                           onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                            <i class="bi bi-plus-circle me-2"></i>Create New Slider
                        </a>
                        
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-info w-100"
                           style="color: #0891b2 !important; border-color: #0891b2 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; text-decoration: none !important;"
                           onmouseover="this.style.backgroundColor='#0891b2 !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#0891b2 !important';">
                            <i class="bi bi-collection me-2"></i>Manage All Sliders
                        </a>
                        
                        @if($analytics['active_sliders'] > 0)
                            <div class="alert alert-success" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important; border: 1px solid #10b981 !important; border-radius: 8px !important; padding: 12px !important; margin-bottom: 0 !important;">
                                <i class="bi bi-check-circle me-2" style="color: #10b981 !important;"></i>
                                <small style="color: #065f46 !important; font-weight: 600 !important;">{{ $analytics['active_sliders'] }} slider{{ $analytics['active_sliders'] > 1 ? 's' : '' }} currently active</small>
                            </div>
                        @else
                            <div class="alert alert-warning" style="background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border: 1px solid #f59e0b !important; border-radius: 8px !important; padding: 12px !important; margin-bottom: 0 !important;">
                                <i class="bi bi-exclamation-triangle me-2" style="color: #f59e0b !important;"></i>
                                <small style="color: #92400e !important; font-weight: 600 !important;">No active sliders - visitors won't see any banners</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Analytics -->
    <div class="row">
        <div class="col-12">
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-table me-2" style="color: #3182ce !important;"></i>Slider Status Breakdown
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr style="border-bottom: 2px solid #f1f5f9 !important;">
                                    <th style="color: #2d3748 !important; font-weight: 700 !important; font-size: 14px !important; padding: 1rem 0.5rem !important;">Status</th>
                                    <th style="color: #2d3748 !important; font-weight: 700 !important; font-size: 14px !important; padding: 1rem 0.5rem !important;">Count</th>
                                    <th style="color: #2d3748 !important; font-weight: 700 !important; font-size: 14px !important; padding: 1rem 0.5rem !important;">Percentage</th>
                                    <th style="color: #2d3748 !important; font-weight: 700 !important; font-size: 14px !important; padding: 1rem 0.5rem !important;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #f8fafc !important;">
                                    <td style="padding: 1rem 0.5rem !important;">
                                        <span class="badge" style="background: #10b981 !important; color: #ffffff !important; font-size: 11px !important; padding: 6px 12px !important; border-radius: 20px !important;">Active</span>
                                    </td>
                                    <td style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; padding: 1rem 0.5rem !important;">{{ $analytics['active_sliders'] }}</td>
                                    <td style="color: #10b981 !important; font-weight: 600 !important; font-size: 14px !important; padding: 1rem 0.5rem !important;">{{ $analytics['total_sliders'] > 0 ? round(($analytics['active_sliders'] / $analytics['total_sliders']) * 100, 1) : 0 }}%</td>
                                    <td style="color: #4a5568 !important; font-size: 13px !important; padding: 1rem 0.5rem !important;">Currently visible to website visitors</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #f8fafc !important;">
                                    <td style="padding: 1rem 0.5rem !important;">
                                        <span class="badge" style="background: #3182ce !important; color: #ffffff !important; font-size: 11px !important; padding: 6px 12px !important; border-radius: 20px !important;">Scheduled</span>
                                    </td>
                                    <td style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; padding: 1rem 0.5rem !important;">{{ $analytics['scheduled_sliders'] }}</td>
                                    <td style="color: #3182ce !important; font-weight: 600 !important; font-size: 14px !important; padding: 1rem 0.5rem !important;">{{ $analytics['total_sliders'] > 0 ? round(($analytics['scheduled_sliders'] / $analytics['total_sliders']) * 100, 1) : 0 }}%</td>
                                    <td style="color: #4a5568 !important; font-size: 13px !important; padding: 1rem 0.5rem !important;">Will activate automatically on start date</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #f8fafc !important;">
                                    <td style="padding: 1rem 0.5rem !important;">
                                        <span class="badge" style="background: #6b7280 !important; color: #ffffff !important; font-size: 11px !important; padding: 6px 12px !important; border-radius: 20px !important;">Expired</span>
                                    </td>
                                    <td style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; padding: 1rem 0.5rem !important;">{{ $analytics['expired_sliders'] }}</td>
                                    <td style="color: #6b7280 !important; font-weight: 600 !important; font-size: 14px !important; padding: 1rem 0.5rem !important;">{{ $analytics['total_sliders'] > 0 ? round(($analytics['expired_sliders'] / $analytics['total_sliders']) * 100, 1) : 0 }}%</td>
                                    <td style="color: #4a5568 !important; font-size: 13px !important; padding: 1rem 0.5rem !important;">Past campaigns that have ended</td>
                                </tr>
                                <tr>
                                    <td style="padding: 1rem 0.5rem !important;">
                                        <span class="badge" style="background: #ef4444 !important; color: #ffffff !important; font-size: 11px !important; padding: 6px 12px !important; border-radius: 20px !important;">Inactive</span>
                                    </td>
                                    <td style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; padding: 1rem 0.5rem !important;">{{ $analytics['inactive_sliders'] }}</td>
                                    <td style="color: #ef4444 !important; font-weight: 600 !important; font-size: 14px !important; padding: 1rem 0.5rem !important;">{{ $analytics['total_sliders'] > 0 ? round(($analytics['inactive_sliders'] / $analytics['total_sliders']) * 100, 1) : 0 }}%</td>
                                    <td style="color: #4a5568 !important; font-size: 13px !important; padding: 1rem 0.5rem !important;">Manually disabled sliders</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* CLEAN SLIDERS ANALYTICS - Professional Styling */
    .performance-metric {
        transition: all 0.2s ease !important;
    }
    
    .performance-metric:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
    }
    
    .recent-slider-item {
        transition: all 0.2s ease !important;
    }
    
    .expiring-item {
        transition: all 0.2s ease !important;
    }
    
    .expiring-item:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2) !important;
    }
    
    .table td {
        border-bottom: 1px solid #f8fafc !important;
    }
    
    .table tr:last-child td {
        border-bottom: none !important;
    }
    
    .alert {
        transition: all 0.2s ease !important;
    }
    
    .alert:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endpush
@endsection
