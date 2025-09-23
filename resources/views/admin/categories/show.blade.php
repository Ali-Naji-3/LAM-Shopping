@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: var(--text-primary); font-weight: var(--font-semibold);">
                👁️ Category Details: {{ $category->name }}
            </h2>
            <p class="text-muted mb-0">Complete information about this category</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-2"></i>Edit Category
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Categories
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Basic Information Card - Clean Styling -->
            <div class="card mb-4" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%); border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0; padding: 1rem 1.5rem;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-info-circle me-2" style="color: #3182ce !important;"></i>Basic Information
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    <div class="row">
                        <!-- Category Image -->
                        <div class="col-md-4 text-center mb-4">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" 
                                     alt="{{ $category->name }}" 
                                     class="img-fluid rounded shadow"
                                     style="max-width: 250px; max-height: 250px; object-fit: cover; border: 2px solid #e2e8f0; border-radius: 12px;">
                            @else
                                <div class="d-flex align-items-center justify-content-center rounded shadow" 
                                     style="width: 250px; height: 250px; margin: 0 auto; background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%); border: 2px solid #e2e8f0; border-radius: 12px;">
                                    <i class="bi bi-image display-1" style="color: #718096 !important;"></i>
                                </div>
                                <p class="mt-3 small" style="color: #4a5568 !important; font-weight: 500 !important; font-size: 12px !important;">No image uploaded</p>
                            @endif
                        </div>
                        
                        <!-- Category Details -->
                        <div class="col-md-8">
                            <table class="table table-borderless" style="margin-bottom: 0;">
                                <tbody>
                                    <tr style="border-bottom: 1px solid #f7fafc;">
                                        <td width="35%" class="fw-semibold py-3" style="color: #4a5568 !important; font-weight: 500 !important; font-size: 13px !important; text-transform: uppercase !important; letter-spacing: 0.05em !important;">Name:</td>
                                        <td class="py-3" style="color: #1a202c !important; font-weight: 600 !important; font-size: 15px !important;">{{ $category->name }}</td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #f7fafc;">
                                        <td class="fw-semibold py-3" style="color: #4a5568 !important; font-weight: 500 !important; font-size: 13px !important; text-transform: uppercase !important; letter-spacing: 0.05em !important;">Slug:</td>
                                        <td class="py-3">
                                            <code style="background: #f8fafc; color: #2d3748 !important; padding: 4px 8px; border-radius: 6px; font-size: 13px; border: 1px solid #e2e8f0;">
                                                {{ $category->slug }}
                                            </code>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #f7fafc;">
                                        <td class="fw-semibold py-3" style="color: #4a5568 !important; font-weight: 500 !important; font-size: 13px !important; text-transform: uppercase !important; letter-spacing: 0.05em !important;">Status:</td>
                                        <td class="py-3">
                                            @if($category->is_active)
                                                <span class="badge" style="background-color: #38a169 !important; color: #ffffff !important; font-size: 12px !important; padding: 0.375rem 0.75rem !important; border-radius: 6px !important;">
                                                    <i class="bi bi-check-circle me-1"></i>Active
                                                </span>
                                            @else
                                                <span class="badge" style="background-color: #e53e3e !important; color: #ffffff !important; font-size: 12px !important; padding: 0.375rem 0.75rem !important; border-radius: 6px !important;">
                                                    <i class="bi bi-x-circle me-1"></i>Inactive
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #f7fafc;">
                                        <td class="fw-semibold py-3" style="color: #4a5568 !important; font-weight: 500 !important; font-size: 13px !important; text-transform: uppercase !important; letter-spacing: 0.05em !important;">Parent:</td>
                                        <td class="py-3">
                                            @if($category->parent)
                                                <a href="{{ route('admin.categories.show', $category->parent) }}" 
                                                   class="text-decoration-none" style="color: #3182ce !important; font-weight: 500 !important; transition: all 0.2s ease;"
                                                   onmouseover="this.style.color='#2c5aa0 !important';"
                                                   onmouseout="this.style.color='#3182ce !important';">
                                                    <i class="bi bi-folder-fill me-1" style="color: #3182ce !important;"></i>{{ $category->parent->name }}
                                                </a>
                                            @else
                                                <span class="badge" style="background-color: #3182ce !important; color: #ffffff !important; font-size: 12px !important; padding: 0.375rem 0.75rem !important; border-radius: 6px !important;">Root Category</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #f7fafc;">
                                        <td class="fw-semibold py-3" style="color: #4a5568 !important; font-weight: 500 !important; font-size: 13px !important; text-transform: uppercase !important; letter-spacing: 0.05em !important;">Order:</td>
                                        <td class="py-3" style="color: #2d3748 !important; font-weight: 500 !important; font-size: 14px !important;">{{ $category->order }}</td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #f7fafc;">
                                        <td class="fw-semibold py-3" style="color: #4a5568 !important; font-weight: 500 !important; font-size: 13px !important; text-transform: uppercase !important; letter-spacing: 0.05em !important;">Created:</td>
                                        <td class="py-3" style="color: #2d3748 !important; font-weight: 400 !important; font-size: 14px !important;">{{ $category->created_at->format('M d, Y \a\t h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold py-3" style="color: #4a5568 !important; font-weight: 500 !important; font-size: 13px !important; text-transform: uppercase !important; letter-spacing: 0.05em !important;">Updated:</td>
                                        <td class="py-3" style="color: #2d3748 !important; font-weight: 400 !important; font-size: 14px !important;">{{ $category->updated_at->format('M d, Y \a\t h:i A') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    @if($category->description)
                        <div class="mt-4" style="padding-top: 1.5rem; border-top: 1px solid #f7fafc;">
                            <h6 style="color: #4a5568 !important; font-weight: 500 !important; font-size: 13px !important; text-transform: uppercase !important; letter-spacing: 0.05em !important; margin-bottom: 1rem !important;">Description:</h6>
                            <div style="padding: 1.25rem; background: #f8fafc; border-radius: 8px; border-left: 3px solid #e2e8f0;">
                                <p style="color: #2d3748 !important; font-size: 15px !important; line-height: 1.7 !important; margin-bottom: 0;">{{ $category->description }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sub-categories Card - Clean Styling -->
            @if($category->children->count() > 0)
                <div class="card mb-4" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                    <div class="card-header d-flex justify-content-between align-items-center" 
                         style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%); border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0; padding: 1rem 1.5rem;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                            <i class="bi bi-folder me-2" style="color: #3182ce !important;"></i>Sub-categories ({{ $category->children->count() }})
                        </h5>
                        <a href="{{ route('admin.categories.index', ['parent_id' => $category->id]) }}" 
                           class="btn btn-sm btn-outline-primary" 
                           style="color: #3182ce !important; border-color: #3182ce !important; background: transparent !important; transition: all 0.2s ease !important;" 
                           onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';" 
                           onmouseout="this.style.backgroundColor='transparent !important'; this.style.color='#3182ce !important';">
                            View All
                        </a>
                    </div>
                    <div class="card-body" style="padding: 2rem;">
                        <div class="row">
                            @foreach($category->children->take(6) as $child)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card h-100" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); transition: all 0.2s ease;" 
                                         onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)'; this.style.borderColor='#3182ce';" 
                                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1)'; this.style.borderColor='#e2e8f0';">
                                        <div class="card-body text-center" style="padding: 1.5rem;">
                                            @if($child->image)
                                                <img src="{{ asset('storage/' . $child->image) }}" 
                                                     alt="{{ $child->name }}" 
                                                     class="img-thumbnail mb-3"
                                                     style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #e2e8f0; border-radius: 8px;">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center mb-3 mx-auto rounded" 
                                                     style="width: 60px; height: 60px; background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%); border: 2px solid #e2e8f0;">
                                                    <i class="bi bi-folder" style="color: #718096 !important; font-size: 1.5rem;"></i>
                                                </div>
                                            @endif
                                            <h6 class="card-title mb-2" style="color: #1a202c !important; font-weight: 600 !important; font-size: 15px !important; line-height: 1.4;">{{ $child->name }}</h6>
                                            <small style="color: #4a5568 !important; font-weight: 500 !important; font-size: 12px !important; display: block !important; margin-bottom: 1rem !important;">{{ $child->products_count }} products</small>
                                            <div class="mt-2 d-flex gap-1 justify-content-center">
                                                <a href="{{ route('admin.categories.show', $child) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   style="color: #3182ce !important; border-color: #3182ce !important; background: transparent !important; font-size: 12px !important; padding: 0.25rem 0.75rem !important;" 
                                                   onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';" 
                                                   onmouseout="this.style.backgroundColor='transparent !important'; this.style.color='#3182ce !important';">View</a>
                                                <a href="{{ route('admin.categories.edit', $child) }}" 
                                                   class="btn btn-sm btn-outline-secondary" 
                                                   style="color: #4a5568 !important; border-color: #4a5568 !important; background: transparent !important; font-size: 12px !important; padding: 0.25rem 0.75rem !important;" 
                                                   onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';" 
                                                   onmouseout="this.style.backgroundColor='transparent !important'; this.style.color='#4a5568 !important';">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Contact Messages Card - Clean Styling -->
            <div class="card mb-4" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                <div class="card-header d-flex justify-content-between align-items-center" 
                     style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%); border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0; padding: 1rem 1.5rem;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-envelope me-2" style="color: #3182ce !important;"></i>Contact Messages ({{ $category->contacts()->count() }})
                    </h5>
                    <div class="btn-group">
                        <button type="button" 
                                class="btn btn-sm btn-primary" 
                                data-bs-toggle="modal" 
                                data-bs-target="#newContactModal"
                                style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); border: none; box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3); transition: all 0.2s ease;"
                                onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(0, 123, 255, 0.4)';"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 123, 255, 0.3)';">
                            <i class="bi bi-plus-circle me-1"></i>New Contact
                        </button>
                        <a href="{{ route('admin.categories.contacts', $category) }}" 
                           class="btn btn-sm btn-outline-primary"
                           style="color: #3182ce !important; border-color: #3182ce !important; background: transparent !important; transition: all 0.2s ease !important;"
                           onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='transparent !important'; this.style.color='#3182ce !important';">
                            View All
                        </a>
                    </div>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    @if($category->contacts->count() > 0)
                        @foreach($category->contacts->take(3) as $contact)
                            <div class="contact-item p-4 mb-4 rounded" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); transition: all 0.2s ease;" 
                                 onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)'; this.style.borderColor='#3182ce';" 
                                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1)'; this.style.borderColor='#e2e8f0';">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class="mb-2" style="color: #1a202c !important; font-weight: 600 !important; font-size: 15px !important; line-height: 1.4;">{{ $contact->subject }}</h6>
                                        <small style="color: #4a5568 !important; font-weight: 500 !important; font-size: 12px !important;">{{ $contact->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <span class="badge" style="background-color: {{ $contact->priority === 'urgent' ? '#e53e3e' : ($contact->priority === 'high' ? '#d69e2e' : '#3182ce') }} !important; color: #ffffff !important; font-size: 11px !important; padding: 0.25rem 0.5rem !important;">
                                            {{ ucfirst($contact->priority) }}
                                        </span>
                                        <span class="badge" style="background-color: {{ $contact->status === 'pending' ? '#d69e2e' : '#38a169' }} !important; color: #ffffff !important; font-size: 11px !important; padding: 0.25rem 0.5rem !important;">
                                            {{ ucfirst($contact->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-3" style="padding: 1rem; background: #f8fafc; border-radius: 6px; border-left: 3px solid #e2e8f0;">
                                    <p class="mb-0" style="color: #2d3748 !important; font-size: 14px !important; line-height: 1.6;">{{ Str::limit($contact->message, 100) }}</p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small style="color: #4a5568 !important; font-weight: 500 !important; font-size: 12px !important;">
                                        <i class="bi bi-tag me-1" style="color: #718096 !important;"></i>{{ ucfirst($contact->contact_type) }}
                                    </small>
                                    @if($contact->responses->count() > 0)
                                        <small style="color: #3182ce !important; font-weight: 500 !important; font-size: 12px !important;">
                                            <i class="bi bi-reply me-1" style="color: #3182ce !important;"></i>{{ $contact->responses->count() }} responses
                                        </small>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5" style="padding: 3rem 2rem;">
                            <i class="bi bi-envelope display-4" style="color: #718096 !important; margin-bottom: 1rem;"></i>
                            <h6 class="mt-3" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 16px !important;">No Contact Messages</h6>
                            <p style="color: #4a5568 !important; font-size: 14px !important; margin-bottom: 0;">No contact messages have been received for this category yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Statistics Card -->
            <div class="card mb-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <div class="card-header" style="background: var(--bg-secondary); border-bottom: 1px solid var(--border-color);">
                    <h5 class="mb-0" style="color: var(--text-primary);">
                        <i class="bi bi-bar-chart me-2"></i>Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="stat-item p-3 rounded" style="background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                                <div class="stat-number h3 mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 1.75rem !important;">
                                    {{ $category->products->count() }}
                                </div>
                                <div class="stat-label small" style="color: #4a5568 !important; font-weight: 500 !important; font-size: 12px !important; text-transform: uppercase !important; letter-spacing: 0.05em !important;">Products</div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="stat-item p-3 rounded" style="background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                                <div class="stat-number h3 mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 1.75rem !important;">
                                    {{ $category->children->count() }}
                                </div>
                                <div class="stat-label small" style="color: #4a5568 !important; font-weight: 500 !important; font-size: 12px !important; text-transform: uppercase !important; letter-spacing: 0.05em !important;">Sub-categories</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item p-3 rounded" style="background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                                <div class="stat-number h3 mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 1.75rem !important;">
                                    {{ $category->contacts->count() }}
                                </div>
                                <div class="stat-label small" style="color: #4a5568 !important; font-weight: 500 !important; font-size: 12px !important; text-transform: uppercase !important; letter-spacing: 0.05em !important;">Contacts</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item p-3 rounded" style="background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                                <div class="stat-number h3 mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 1.75rem !important;">
                                    {{ $category->contacts->where('status', 'pending')->count() }}
                                </div>
                                <div class="stat-label small" style="color: #4a5568 !important; font-weight: 500 !important; font-size: 12px !important; text-transform: uppercase !important; letter-spacing: 0.05em !important;">Pending</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card mb-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <div class="card-header" style="background: var(--bg-secondary); border-bottom: 1px solid var(--border-color);">
                    <h5 class="mb-0" style="color: var(--text-primary);">
                        <i class="bi bi-lightning me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="row g-3">
                        <!-- Primary Actions -->
                        <div class="col-md-6">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary w-100"
                               style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
                               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <i class="bi bi-pencil me-2"></i>Edit Category
                            </a>
                        </div>
                        
                        <div class="col-md-6">
                            <a href="{{ route('admin.categories.analytics', $category) }}" class="btn btn-outline-dark w-100"
                               style="color: #374151 !important; border-color: #374151 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#374151 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#374151 !important';">
                                <i class="bi bi-graph-up me-2"></i>Analytics Dashboard
                            </a>
                        </div>
                        
                        <!-- Entity Connections -->
                        <div class="col-md-6">
                            <a href="{{ route('admin.categories.products', $category) }}" class="btn btn-outline-primary w-100"
                               style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                                <i class="bi bi-box me-2"></i>Products ({{ $category->products()->count() }})
                            </a>
                        </div>
                        
                        <div class="col-md-6">
                            <a href="{{ route('admin.categories.contacts', $category) }}" class="btn btn-outline-info w-100"
                               style="color: #0ea5e9 !important; border-color: #0ea5e9 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#0ea5e9 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#0ea5e9 !important';">
                                <i class="bi bi-envelope me-2"></i>Contacts ({{ $category->contacts()->count() }})
                            </a>
                        </div>
                        
                        <div class="col-md-6">
                            <a href="{{ route('admin.categories.brands', $category) }}" class="btn btn-outline-success w-100"
                               style="color: #10b981 !important; border-color: #10b981 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#10b981 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#10b981 !important';">
                                <i class="bi bi-award me-2"></i>Brands ({{ $connectionCounts['brands_count'] }})
                            </a>
                        </div>
                        
                        <div class="col-md-6">
                            <a href="{{ route('admin.categories.reviews', $category) }}" class="btn btn-outline-warning w-100"
                               style="color: #f59e0b !important; border-color: #f59e0b !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#f59e0b !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#f59e0b !important';">
                                <i class="bi bi-star me-2"></i>Reviews ({{ $connectionCounts['reviews_count'] }})
                            </a>
                        </div>
                        
                        <!-- Management Actions -->
                        @if($category->children()->count() > 0)
                        <div class="col-md-6">
                            <a href="{{ route('admin.categories.index', ['parent_id' => $category->id]) }}" class="btn btn-outline-secondary w-100"
                               style="color: #6b7280 !important; border-color: #6b7280 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#6b7280 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#6b7280 !important';">
                                <i class="bi bi-folder me-2"></i>Sub-categories ({{ $category->children()->count() }})
                            </a>
                        </div>
                        @endif
                        
                        <div class="col-md-6">
                            <a href="{{ route('admin.categories.create') }}?parent_id={{ $category->id }}" class="btn btn-outline-success w-100"
                               style="color: #10b981 !important; border-color: #10b981 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#10b981 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#10b981 !important';">
                                <i class="bi bi-plus-circle me-2"></i>Add Sub-category
                            </a>
                        </div>
                        
                        <div class="col-md-12">
                            <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    style="color: #e53e3e !important; border-color: #e53e3e !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.backgroundColor='#e53e3e !important'; this.style.color='#ffffff !important';"
                                    onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#e53e3e !important';">
                                <i class="bi bi-trash me-2"></i>Delete Category
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Tree Card - Clean Styling -->
            @if($category->parent || $category->children->count() > 0)
                <div class="card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%); border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0; padding: 1rem 1.5rem;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                            <i class="bi bi-diagram-3 me-2" style="color: #3182ce !important;"></i>Category Tree
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem;">
                        @if($category->parent)
                            <div class="mb-4">
                                <small style="color: #4a5568 !important; font-weight: 500 !important; font-size: 12px !important; text-transform: uppercase !important; letter-spacing: 0.05em !important;">Parent:</small>
                                <div class="mt-2" style="padding: 1rem; background: #f8fafc; border-radius: 8px; border-left: 3px solid #3182ce;">
                                    <a href="{{ route('admin.categories.show', $category->parent) }}" 
                                       class="text-decoration-none d-flex align-items-center" style="color: #3182ce !important; font-weight: 500 !important; transition: all 0.2s ease;" 
                                       onmouseover="this.style.color='#2c5aa0 !important';" 
                                       onmouseout="this.style.color='#3182ce !important';">
                                        <i class="bi bi-arrow-up me-2" style="color: #3182ce !important;"></i>{{ $category->parent->name }}
                                    </a>
                                </div>
                            </div>
                        @endif
                        
                        <div class="current-category p-3 rounded mb-4" style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%); color: #ffffff !important; border: none; box-shadow: 0 2px 4px rgba(49, 130, 206, 0.2);">
                            <i class="bi bi-folder-fill me-2" style="color: #ffffff !important;"></i>
                            <span style="font-weight: 600 !important; font-size: 15px !important;">{{ $category->name }} (Current)</span>
                        </div>
                        
                        @if($category->children->count() > 0)
                            <div>
                                <small style="color: #4a5568 !important; font-weight: 500 !important; font-size: 12px !important; text-transform: uppercase !important; letter-spacing: 0.05em !important; margin-bottom: 1rem !important; display: block !important;">Children:</small>
                                <ul class="list-unstyled" style="margin-top: 1rem !important;">
                                    @foreach($category->children->take(5) as $child)
                                        <li class="mb-2" style="padding: 0.75rem; background: #f8fafc; border-radius: 6px; border-left: 2px solid #e2e8f0; transition: all 0.2s ease;" 
                                            onmouseover="this.style.borderLeftColor='#3182ce'; this.style.backgroundColor='#f0f9ff';" 
                                            onmouseout="this.style.borderLeftColor='#e2e8f0'; this.style.backgroundColor='#f8fafc';">
                                            <a href="{{ route('admin.categories.show', $child) }}" 
                                               class="text-decoration-none d-flex align-items-center" style="color: #2d3748 !important; font-weight: 500 !important; font-size: 14px !important;" 
                                               onmouseover="this.style.color='#3182ce !important';" 
                                               onmouseout="this.style.color='#2d3748 !important';">
                                                <i class="bi bi-arrow-down me-2" style="color: #718096 !important;"></i>{{ $child->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                    @if($category->children->count() > 5)
                                        <li style="padding: 0.5rem; color: #718096 !important; font-size: 13px !important; font-style: italic !important; text-align: center !important;">
                                            ... and {{ $category->children->count() - 5 }} more
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- New Contact Modal -->
<div class="modal fade" id="newContactModal" tabindex="-1" data-bs-backdrop="true" data-bs-keyboard="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background: var(--bg-card); border: 1px solid var(--border-color);">
            <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                <h5 class="modal-title" style="color: var(--text-primary);">
                    <i class="bi bi-envelope me-2"></i>New Contact Message
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="clearModalBackdrops();"></button>
            </div>
            <form method="POST" action="{{ route('admin.categories.contacts.store', $category) }}">
                @csrf
                <div class="modal-body" style="background: white; color: #333;">
                    <div class="mb-3">
                        <label for="contact_subject" class="form-label" style="color: #333;">Subject *</label>
                        <input type="text" class="form-control" id="contact_subject" name="subject" required
                               style="background: white; border: 1px solid #ced4da; color: #333;"
                               placeholder="Enter contact subject">
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="contact_type" class="form-label" style="color: #333;">Type *</label>
                            <select class="form-control" id="contact_type" name="contact_type" required
                                    style="background: white; border: 1px solid #ced4da; color: #333;">
                                <option value="inquiry">Inquiry</option>
                                <option value="complaint">Complaint</option>
                                <option value="suggestion">Suggestion</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="contact_priority" class="form-label" style="color: #333;">Priority *</label>
                            <select class="form-control" id="contact_priority" name="priority" required
                                    style="background: white; border: 1px solid #ced4da; color: #333;">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="contact_message" class="form-label" style="color: #333;">Message *</label>
                        <textarea class="form-control" id="contact_message" name="message" rows="4" required
                                  style="background: white; border: 1px solid #ced4da; color: #333;"
                                  placeholder="Enter your message..."></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Contact</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="background: var(--bg-card); border: 1px solid var(--border-color);">
            <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>Delete Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p style="color: var(--text-primary);">Are you sure you want to delete the category "{{ $category->name }}"?</p>
                @if($category->products->count() > 0)
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        This category has {{ $category->products->count() }} associated products. You cannot delete it until you reassign or delete the products.
                    </div>
                @endif
                @if($category->children->count() > 0)
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        This category has {{ $category->children->count() }} sub-categories. They will be moved to the parent level.
                    </div>
                @endif
            </div>
            <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                @if($category->products->count() == 0)
                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Category</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fix modal backdrop issues
    function clearModalBackdrops() {
        // Remove any stuck modal backdrops
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.remove();
        });
        // Remove modal-open class from body
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    }
    
    // Clear any existing backdrops on page load
    clearModalBackdrops();
    
    // Handle New Contact Modal
    const newContactButtons = document.querySelectorAll('[data-bs-target="#newContactModal"]');
    const newContactModal = document.getElementById('newContactModal');
    
    if (newContactModal) {
        // Remove any existing modal instance
        const existingModal = bootstrap.Modal.getInstance(newContactModal);
        if (existingModal) {
            existingModal.dispose();
        }
        
        // Initialize fresh modal
        const modal = new bootstrap.Modal(newContactModal, {
            backdrop: true,
            keyboard: true,
            focus: true
        });
        
        // Add click event listeners
        newContactButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                clearModalBackdrops(); // Clear any stuck backdrops first
                console.log('Opening new contact modal...');
                modal.show();
            });
        });
        
        // Handle modal close events
        newContactModal.addEventListener('hidden.bs.modal', function() {
            clearModalBackdrops();
        });
        
        // Handle escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                modal.hide();
                clearModalBackdrops();
            }
        });
    }
    
    // Handle Delete Modal
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        const deleteButtons = document.querySelectorAll('[data-bs-target="#deleteModal"]');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                clearModalBackdrops();
                
                const existingModal = bootstrap.Modal.getInstance(deleteModal);
                if (existingModal) {
                    existingModal.dispose();
                }
                const modal = new bootstrap.Modal(deleteModal);
                modal.show();
            });
        });
    }
    
    // Global click handler to clear stuck backdrops
    document.addEventListener('click', function(e) {
        // If clicking outside modal and no modal is actually open
        if (!document.querySelector('.modal.show') && document.querySelector('.modal-backdrop')) {
            clearModalBackdrops();
        }
    });
    
    // Fix modal form submission
    const contactForm = document.querySelector('#newContactModal form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            console.log('Contact form submitted');
            // Form will submit normally, then clear backdrops
            setTimeout(clearModalBackdrops, 100);
        });
    }
});
</script>
@endpush

@push('styles')
<style>
    /* CONTACT ITEMS STYLING - WHITE BACKGROUND BLACK TEXT */
    .contact-item {
        background: white !important;
        border: 2px solid #ddd !important;
        color: #000 !important;
        transition: all 0.3s ease;
    }
    
    .contact-item:hover {
        background: #f8f9fa !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2) !important;
    }
    
    .contact-item *,
    .contact-item h6,
    .contact-item p,
    .contact-item div,
    .contact-item small {
        color: #000 !important;
    }
    
    .contact-item .text-muted {
        color: #555 !important;
    }
    
    /* CLEAN STATISTICS STYLING - Enhanced for Easy Scanning */
    .stat-item {
        transition: all 0.2s ease !important;
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        padding: 1.5rem 1rem !important;
        text-align: center !important;
    }
    
    .stat-item:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
        border-color: #3182ce !important;
    }
    
    /* Clean stat numbers */
    .stat-item .stat-number {
        color: #1a202c !important;
        font-weight: 700 !important;
        font-size: 1.75rem !important;
        margin-bottom: 0.5rem !important;
        line-height: 1.2 !important;
    }
    
    /* Clean stat labels */
    .stat-item .stat-label {
        color: #4a5568 !important;
        font-weight: 500 !important;
        font-size: 12px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        margin: 0 !important;
    }
    
    .current-category {
        font-weight: var(--font-semibold);
    }
    
    /* COMPLETE MODAL STYLING - WHITE BACKGROUND BLACK TEXT */
    .modal-content {
        background: white !important;
        border: 2px solid #ddd !important;
        color: #000 !important;
    }
    
    .modal-header {
        background: #f8f9fa !important;
        border-bottom: 2px solid #ddd !important;
        color: #000 !important;
    }
    
    .modal-body {
        background: white !important;
        color: #000 !important;
    }
    
    .modal-footer {
        background: #f8f9fa !important;
        border-top: 2px solid #ddd !important;
        color: #000 !important;
    }
    
    .modal-title {
        color: #000 !important;
        font-weight: 600;
    }
    
    .modal *,
    .modal p,
    .modal div,
    .modal label,
    .modal small {
        color: #000 !important;
    }
    
    .modal .text-muted {
        color: #555 !important;
    }
    
    /* Form controls in modals */
    .modal .form-control {
        background: white !important;
        border: 2px solid #ccc !important;
        color: #000 !important;
    }
    
    .modal .form-control:focus {
        background: white !important;
        border: 2px solid #007bff !important;
        color: #000 !important;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.3) !important;
    }
    
    .modal .form-control::placeholder {
        color: #666 !important;
    }
    
    .modal .form-label {
        color: #000 !important;
        font-weight: 600;
    }
    
    /* Alert styling in modals */
    .modal .alert-warning {
        background: #fff3cd !important;
        border: 2px solid #ffc107 !important;
        color: #856404 !important;
    }
    
    .modal .alert-info {
        background: #d1ecf1 !important;
        border: 2px solid #17a2b8 !important;
        color: #0c5460 !important;
    }
    
    /* Button styling */
    .btn-outline-primary:hover {
        background-color: #007bff !important;
        border-color: #007bff !important;
        color: white !important;
    }
    
    .btn-outline-secondary:hover {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
        color: white !important;
    }
    
    .btn-outline-info:hover {
        background-color: #17a2b8 !important;
        border-color: #17a2b8 !important;
        color: white !important;
    }
    
    .btn-outline-success:hover {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
        color: white !important;
    }
    
    .btn-outline-danger:hover {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
        color: white !important;
    }
    
    /* Ensure all outline buttons have white text */
    .btn-outline-primary {
        color: #ffffff !important;
        border-color: #ffffff !important;
        background: rgba(255, 255, 255, 0.1) !important;
    }
    
    .btn-outline-primary:hover {
        background: #ffffff !important;
        border-color: #ffffff !important;
        color: #1e293b !important;
    }
    
    .btn-outline-info {
        color: #ffffff !important;
        border-color: #ffffff !important;
        background: rgba(255, 255, 255, 0.1) !important;
    }
    
    .btn-outline-info:hover {
        background: #ffffff !important;
        border-color: #ffffff !important;
        color: #1e293b !important;
    }
    
    .btn-outline-secondary {
        color: #ffffff !important;
        border-color: #ffffff !important;
        background: rgba(255, 255, 255, 0.1) !important;
    }
    
    .btn-outline-secondary:hover {
        background: #ffffff !important;
        border-color: #ffffff !important;
        color: #1e293b !important;
    }
</style>
@endpush
@endsection
