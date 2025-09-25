@extends('admin.dashboard')

@section('content')
<div class="container-fluid contacts-page">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important;">
                📧 Contact Messages for: {{ $category->name }}
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">Manage customer inquiries and support requests for this category</p>
        </div>
        <div class="btn-group">
            <button type="button" 
                    class="btn btn-primary" 
                    data-bs-toggle="modal" 
                    data-bs-target="#newContactModal"
                    style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); border: none; box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3); transition: all 0.2s ease; padding: 10px 20px;"
                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(0, 123, 255, 0.4)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 123, 255, 0.3)';">
                <i class="bi bi-plus-circle me-2"></i>New Contact
            </button>
            <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-outline-info">
                <i class="bi bi-eye me-2"></i>View Category
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Categories
            </a>
        </div>
    </div>

    <!-- Category Info Card -->
    <div class="card mb-4" style="background: #ffffff; border: 1px solid #e2e8f0;">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" 
                             alt="{{ $category->name }}" 
                             class="img-thumbnail"
                             style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                        <div class="bg-secondary d-flex align-items-center justify-content-center rounded" 
                             style="width: 80px; height: 80px; margin: 0 auto;">
                            <i class="bi bi-folder" style="color: var(--text-muted); font-size: 1.5rem;"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <h5 class="mb-1" style="color: #1a202c !important; font-weight: 600 !important;">{{ $category->name }}</h5>
                    @if($category->description)
                        <p class="text-muted mb-2">{{ Str::limit($category->description, 100) }}</p>
                    @endif
                    <div class="d-flex gap-2">
                        @if($category->parent)
                            <span class="badge bg-info">Child of {{ $category->parent->name }}</span>
                        @else
                            <span class="badge bg-primary">Root Category</span>
                        @endif
                        <span class="badge bg-{{ $category->is_active ? 'success' : 'danger' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="stat-item">
                                <div class="h5 mb-0" style="color: var(--success-color);">{{ $contacts->total() }}</div>
                                <small class="text-muted">Total Contacts</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-item">
                                <div class="h5 mb-0" style="color: var(--warning-color);">
                                    {{ $contacts->where('status', 'pending')->count() }}
                                </div>
                                <small class="text-muted">Pending</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-item">
                                <div class="h5 mb-0" style="color: var(--info-color);">
                                    {{ $contacts->where('status', 'resolved')->count() }}
                                </div>
                                <small class="text-muted">Resolved</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card mb-4" style="background: #ffffff; border: 1px solid #e2e8f0;">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important;">Search</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search by subject or message..."
                           value="{{ request('search') }}"
                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important;">
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important;">Status</label>
                    <select name="status" class="form-control" 
                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important;">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important;">Type</label>
                    <select name="type" class="form-control" 
                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important;">
                        <option value="">All Types</option>
                        <option value="inquiry" {{ request('type') === 'inquiry' ? 'selected' : '' }}>Inquiry</option>
                        <option value="complaint" {{ request('type') === 'complaint' ? 'selected' : '' }}>Complaint</option>
                        <option value="suggestion" {{ request('type') === 'suggestion' ? 'selected' : '' }}>Suggestion</option>
                        <option value="other" {{ request('type') === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important;">Priority</label>
                    <select name="priority" class="form-control" 
                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important;">
                        <option value="">All Priorities</option>
                        <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                        <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                        <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.categories.contacts', $category) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Contacts List -->
    <div class="card" style="background: #ffffff; border: 1px solid #e2e8f0;">
        <div class="card-body">
            @if($contacts->count() > 0)
                <div class="contacts-list">
                    @foreach($contacts as $contact)
                        <div class="contact-item p-4 mb-3 rounded" 
                             style="background: #ffffff; border: 1px solid #e2e8f0;">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="mb-1" style="color: #1a202c;">{{ $contact->subject }}</h5>
                                            <div class="d-flex gap-2 mb-2">
                                                <span class="badge bg-{{ $contact->priority === 'urgent' ? 'danger' : ($contact->priority === 'high' ? 'warning' : ($contact->priority === 'medium' ? 'info' : 'secondary')) }}">
                                                    <i class="bi bi-flag me-1"></i>{{ ucfirst($contact->priority) }}
                                                </span>
                                                <span class="badge bg-{{ $contact->status === 'pending' ? 'warning' : 'success' }}">
                                                    <i class="bi bi-{{ $contact->status === 'pending' ? 'clock' : 'check-circle' }} me-1"></i>{{ ucfirst($contact->status) }}
                                                </span>
                                                <span class="badge bg-info">
                                                    <i class="bi bi-tag me-1"></i>{{ ucfirst($contact->contact_type) }}
                                                </span>
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ $contact->created_at->diffForHumans() }}</small>
                                    </div>
                                    
                                    <div class="message-content mb-3">
                                        <p class="mb-0" style="color: #2d3748;">{{ $contact->message }}</p>
                                    </div>
                                    
                                    @if($contact->responses->count() > 0)
                                        <div class="responses-section">
                                            <h6 class="mb-2" style="color: #1a202c;">
                                                <i class="bi bi-reply me-1"></i>Responses ({{ $contact->responses->count() }})
                                            </h6>
                                            @foreach($contact->responses->take(2) as $response)
                                                <div class="response-item p-3 mb-2 rounded" 
                                                     style="background: #ffffff; border-left: 3px solid var(--primary-color);">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <small class="fw-semibold" style="color: #1a202c;">
                                                            Admin Response
                                                        </small>
                                                        <small class="text-muted">{{ $response->created_at->diffForHumans() }}</small>
                                                    </div>
                                                    <p class="mb-0 small" style="color: #2d3748;">
                                                        {{ Str::limit($response->message, 150) }}
                                                    </p>
                                                </div>
                                            @endforeach
                                            @if($contact->responses->count() > 2)
                                                <small class="text-muted">
                                                    ... and {{ $contact->responses->count() - 2 }} more responses
                                                </small>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="contact-meta p-3 rounded" style="background: #ffffff;">
                                        <h6 class="mb-3" style="color: #1a202c;">Contact Details</h6>
                                        
                                        <div class="mb-2">
                                            <small class="text-muted">Contact ID:</small>
                                            <div class="fw-semibold" style="color: #1a202c;">#{{ $contact->id }}</div>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <small class="text-muted">Created:</small>
                                            <div class="small" style="color: #1a202c;">
                                                {{ $contact->created_at->format('M d, Y \a\t h:i A') }}
                                            </div>
                                        </div>
                                        
                                        @if($contact->updated_at != $contact->created_at)
                                            <div class="mb-3">
                                                <small class="text-muted">Last Updated:</small>
                                                <div class="small" style="color: #1a202c;">
                                                    {{ $contact->updated_at->format('M d, Y \a\t h:i A') }}
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#responseModal{{ $contact->id }}">
                                                <i class="bi bi-reply me-1"></i>Add Response
                                            </button>
                                            
                                            @if($contact->status === 'pending')
                                                <form method="POST" action="#" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-success w-100">
                                                        <i class="bi bi-check-circle me-1"></i>Mark Resolved
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="#" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-warning w-100">
                                                        <i class="bi bi-clock me-1"></i>Mark Pending
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteContactModal{{ $contact->id }}">
                                                <i class="bi bi-trash me-1"></i>Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Response Modal for each contact -->
                        <div class="modal fade" id="responseModal{{ $contact->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content" style="background: #ffffff; border: 1px solid #e2e8f0;">
                                    <div class="modal-header" style="border-bottom: 1px solid #e2e8f0;">
                                        <h5 class="modal-title" style="color: #1a202c;">
                                            <i class="bi bi-reply me-2"></i>Add Response to: {{ Str::limit($contact->subject, 30) }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST" action="#">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label" style="color: #2d3748;">Original Message:</label>
                                                <div class="p-3 rounded" style="background: #ffffff; border: 1px solid #e2e8f0;">
                                                    <small class="text-muted">{{ $contact->message }}</small>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="response_message{{ $contact->id }}" class="form-label" style="color: #2d3748;">Your Response *</label>
                                                <textarea class="form-control" id="response_message{{ $contact->id }}" name="message" rows="4" required
                                                          style="background: #ffffff; border: 1px solid #e2e8f0; color: #1a202c;"
                                                          placeholder="Enter your response..."></textarea>
                                            </div>
                                            
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="mark_resolved{{ $contact->id }}" name="mark_resolved" value="1">
                                                <label class="form-check-label" for="mark_resolved{{ $contact->id }}" style="color: #2d3748;">
                                                    Mark this contact as resolved after sending response
                                                </label>
                                            </div>
                                        </div>
                                        <div class="modal-footer" style="border-top: 1px solid #e2e8f0;">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-send me-1"></i>Send Response
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Contact Modal -->
                        <div class="modal fade" id="deleteContactModal{{ $contact->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content" style="background: #ffffff; border: 1px solid #e2e8f0;">
                                    <div class="modal-header" style="border-bottom: 1px solid #e2e8f0;">
                                        <h5 class="modal-title text-danger">
                                            <i class="bi bi-exclamation-triangle me-2"></i>Delete Contact
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p style="color: #1a202c;">Are you sure you want to delete this contact message?</p>
                                        <p class="text-muted small">Subject: "{{ $contact->subject }}"</p>
                                        @if($contact->responses->count() > 0)
                                            <div class="alert alert-warning">
                                                <i class="bi bi-exclamation-triangle me-2"></i>
                                                This contact has {{ $contact->responses->count() }} responses that will also be deleted.
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer" style="border-top: 1px solid #e2e8f0;">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form method="POST" action="#" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete Contact</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-container mt-4" style="background: white; padding: 8px 16px; border-radius: 6px; height: 45px; width: 100%; max-width: 100%; border: 1px solid #ddd;">
                    <div class="pagination-info" style="color: #333; font-weight: 500; font-size: 13px; white-space: nowrap;">
                        Showing {{ $contacts->firstItem() ?? 0 }}-{{ $contacts->lastItem() ?? 0 }} of {{ $contacts->total() }}
                    </div>
                    <div class="pagination-links" style="color: #333;">
                        {{ $contacts->appends(request()->query())->links('vendor.pagination.custom') }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-envelope display-1" style="color: var(--text-muted);"></i>
                    <h4 class="mt-3" style="color: #2d3748;">No Contact Messages</h4>
                    <p class="text-muted">No contact messages have been received for this category yet.</p>
                    <button type="button" 
                            class="btn btn-primary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#newContactModal"
                            style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); border: none; box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3); transition: all 0.2s ease; padding: 12px 24px;"
                            onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(0, 123, 255, 0.4)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 123, 255, 0.3)';">
                        <i class="bi bi-plus-circle me-2"></i>Create First Contact
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- New Contact Modal -->
<div class="modal fade" id="newContactModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="background: #ffffff; border: 1px solid #e2e8f0;">
            <div class="modal-header" style="border-bottom: 1px solid #e2e8f0;">
                <h5 class="modal-title" style="color: #1a202c;">
                    <i class="bi bi-envelope me-2"></i>New Contact Message for {{ $category->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.categories.contacts.store', $category) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="contact_subject" class="form-label" style="color: #2d3748;">Subject *</label>
                        <input type="text" class="form-control" id="contact_subject" name="subject" required
                               style="background: #ffffff; border: 1px solid #e2e8f0; color: #1a202c;"
                               placeholder="Enter contact subject">
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="contact_type" class="form-label" style="color: #2d3748;">Type *</label>
                            <select class="form-control" id="contact_type" name="contact_type" required
                                    style="background: #ffffff; border: 1px solid #e2e8f0; color: #1a202c;">
                                <option value="inquiry">Inquiry</option>
                                <option value="complaint">Complaint</option>
                                <option value="suggestion">Suggestion</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="contact_priority" class="form-label" style="color: #2d3748;">Priority *</label>
                            <select class="form-control" id="contact_priority" name="priority" required
                                    style="background: #ffffff; border: 1px solid #e2e8f0; color: #1a202c;">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="contact_message" class="form-label" style="color: #2d3748;">Message *</label>
                        <textarea class="form-control" id="contact_message" name="message" rows="4" required
                                  style="background: #ffffff; border: 1px solid #e2e8f0; color: #1a202c;"
                                  placeholder="Enter your message..."></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-1"></i>Create Contact
                    </button>
                </div>
            </form>
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
    
    // Fix all response modals
    document.querySelectorAll('[data-bs-target^="#responseModal"]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            clearModalBackdrops();
            
            const targetModalId = this.getAttribute('data-bs-target');
            const targetModal = document.querySelector(targetModalId);
            if (targetModal) {
                const existingModal = bootstrap.Modal.getInstance(targetModal);
                if (existingModal) {
                    existingModal.dispose();
                }
                const modal = new bootstrap.Modal(targetModal);
                modal.show();
            }
        });
    });
    
    // Fix delete modals
    document.querySelectorAll('[data-bs-target^="#deleteContactModal"]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            clearModalBackdrops();
            
            const targetModalId = this.getAttribute('data-bs-target');
            const targetModal = document.querySelector(targetModalId);
            if (targetModal) {
                const existingModal = bootstrap.Modal.getInstance(targetModal);
                if (existingModal) {
                    existingModal.dispose();
                }
                const modal = new bootstrap.Modal(targetModal);
                modal.show();
            }
        });
    });
    
    // Global click handler to clear stuck backdrops
    document.addEventListener('click', function(e) {
        // If clicking outside modal and no modal is actually open
        if (!document.querySelector('.modal.show') && document.querySelector('.modal-backdrop')) {
            clearModalBackdrops();
        }
    });
});
</script>
@endpush

@push('styles')
<style>
    /* FORCE BROWSER REFRESH - Cache Busting */
    .contacts-page {
        /* Timestamp: {{ now()->timestamp }} */
    }
    /* Override contact styling for white background and black text */
    .contact-item {
        transition: all 0.3s ease;
        background: white !important;
        color: #333 !important;
        border: 1px solid #e0e0e0 !important;
    }
    
    .contact-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        background: #f8f9fa !important;
    }
    
    .contact-item h5,
    .contact-item h6,
    .contact-item p,
    .contact-item div,
    .contact-item small {
        color: #333 !important;
    }
    
    .contact-item .text-muted {
        color: #666 !important;
    }
    
    .response-item {
        transition: all 0.3s ease;
        background: #f8f9fa !important;
        color: #333 !important;
        border-left: 3px solid var(--primary-color) !important;
    }
    
    .response-item:hover {
        background: #e9ecef !important;
    }
    
    .response-item p,
    .response-item small,
    .response-item div {
        color: #333 !important;
    }
    
    .response-item .text-muted {
        color: #666 !important;
    }
    
    .contact-meta {
        height: fit-content;
        background: white !important;
        color: #333 !important;
        border: 1px solid #e0e0e0 !important;
    }
    
    .contact-meta h6,
    .contact-meta div,
    .contact-meta small {
        color: #333 !important;
    }
    
    .contact-meta .text-muted {
        color: #666 !important;
    }
    
    .stat-item {
        padding: 8px;
    }
    
    /* Modal content styling */
    .modal-content {
        background: white !important;
        color: #333 !important;
    }
    
    .modal-header,
    .modal-body,
    .modal-footer {
        background: white !important;
        color: #333 !important;
        border-color: #e0e0e0 !important;
    }
    
    .modal-title {
        color: #333 !important;
    }
    
    .modal-body p,
    .modal-body div,
    .modal-body label,
    .modal-body small {
        color: #333 !important;
    }
    
    .modal-body .text-muted {
        color: #666 !important;
    }
    
    /* Form controls in modals with white placeholders */
    .modal .form-control {
        background: linear-gradient(135deg, #334155 0%, #475569 100%) !important;
        border: 1px solid #64748b !important;
        color: #ffffff !important;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    
    .modal .form-control:focus {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%) !important;
        border: 2px solid #3b82f6 !important;
        color: #ffffff !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3) !important;
    }
    
    .modal .form-control::placeholder {
        color: #ffffff !important;
        opacity: 0.8 !important;
    }
    
    .modal .form-control::-webkit-input-placeholder {
        color: #ffffff !important;
        opacity: 0.8 !important;
    }
    
    .modal .form-control::-moz-placeholder {
        color: #ffffff !important;
        opacity: 0.8 !important;
    }
    
    .modal .form-control:-ms-input-placeholder {
        color: #ffffff !important;
        opacity: 0.8 !important;
    }
    
    .modal .form-control:-moz-placeholder {
        color: #ffffff !important;
        opacity: 0.8 !important;
    }
    
    /* Classic Theme Card Styling - Enhanced Spacing */
    .contacts-page .card {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06) !important;
        transition: all 0.2s ease !important;
        margin-bottom: 2rem !important;
    }
    
    .contacts-page .card:hover {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.06) !important;
        transform: translateY(-1px) !important;
    }
    
    .contacts-page .card-body {
        background: #ffffff !important;
        color: #2d3748 !important;
        padding: 2rem !important;
    }
    
    /* Section spacing improvements */
    .contacts-page .message-content {
        margin: 1.5rem 0 !important;
        padding: 1rem !important;
        background: #f8fafc !important;
        border-radius: 8px !important;
        border-left: 3px solid #e2e8f0 !important;
    }
    
    .contacts-page .responses-section {
        margin-top: 2rem !important;
        padding-top: 1.5rem !important;
        border-top: 1px solid #e2e8f0 !important;
    }
    
    /* Contact header spacing */
    .contacts-page .d-flex.justify-content-between {
        margin-bottom: 1.5rem !important;
    }
    
    /* SPECIALIZED TIMESTAMP STYLING - Professional Time Display */
    .contacts-page .text-muted.small,
    .contacts-page .contact-item small.text-muted {
        color: #6b7280 !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%) !important;
        padding: 4px 8px !important;
        border-radius: 12px !important;
        border: 1px solid #e5e7eb !important;
        display: inline-block !important;
        margin-top: 0.25rem !important;
        font-family: 'SF Mono', 'Monaco', 'Inconsolata', monospace !important;
    }
    
    /* Specialized Contact Type Indicators */
    .contacts-page .contact-item .bi-tag {
        color: #3182ce !important;
        margin-right: 4px !important;
    }
    
    .contacts-page .contact-item .bi-reply {
        color: #059669 !important;
        margin-right: 4px !important;
    }
    
    /* Response Count Styling */
    .contacts-page .contact-item small:has(.bi-reply) {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important;
        color: #059669 !important;
        padding: 4px 8px !important;
        border-radius: 12px !important;
        border: 1px solid #a7f3d0 !important;
        font-weight: 600 !important;
    }
    
    .contacts-page .card-header {
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important;
        border-bottom: 1px solid #e2e8f0 !important;
        color: #1a202c !important;  /* Darkest for header text */
        font-weight: 600 !important;
        padding: 1rem 1.5rem !important;
        border-radius: 12px 12px 0 0 !important;
        font-size: 16px !important;
    }
    
    /* CLEAN TEXT COLORS - Enhanced for Easy Scanning */
    .contacts-page h2 {
        color: #1a202c !important;  /* Darker for better contrast */
        font-weight: 700 !important;
        text-shadow: none !important;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        margin-bottom: 1.5rem !important;
        line-height: 1.3 !important;
        letter-spacing: -0.025em !important;
    }
    
    .contacts-page h5 {
        color: #2d3748 !important;  /* Strong dark for readability */
        font-weight: 600 !important;
        text-shadow: none !important;
        margin-bottom: 1rem !important;
        margin-top: 1.5rem !important;
        line-height: 1.4 !important;
    }
    
    .contacts-page h6 {
        color: #4a5568 !important;  /* Medium contrast for hierarchy */
        font-weight: 500 !important;
        text-shadow: none !important;
        margin-bottom: 0.75rem !important;
        margin-top: 1.25rem !important;
        line-height: 1.4 !important;
    }
    
    .contacts-page p {
        color: #2d3748 !important;  /* Clean dark for body text */
        line-height: 1.7 !important;
        text-shadow: none !important;
        margin-bottom: 1.25rem !important;
        font-size: 15px !important;  /* Slightly larger for readability */
    }
    
    .contacts-page div {
        color: #2d3748 !important;
    }
    
    .contacts-page .text-muted {
        color: #718096 !important;  /* Darker muted for better readability */
        opacity: 1 !important;
        margin-bottom: 0.5rem !important;
        line-height: 1.5 !important;
        font-size: 14px !important;
    }
    
    .contacts-page small {
        color: #4a5568 !important;  /* Darker small text for clarity */
        font-weight: 400 !important;
        line-height: 1.4 !important;
        display: inline-block !important;
        margin-bottom: 0.25rem !important;
        font-size: 13px !important;
    }
    
    .contacts-page .fw-semibold,
    .contacts-page .fw-bold {
        color: #1a202c !important;  /* Darkest for emphasis */
        font-weight: 600 !important;
    }
    
        /* SPECIALIZED CONTENT STYLING - ALL CONTENT TRANSFORMATION */
    .contacts-page * {
        box-sizing: border-box !important;
    }
    
    /* GLOBAL PAGE ENHANCEMENT */
    .contacts-page {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
        min-height: 100vh !important;
        padding: 2rem 0 !important;
    }
    
    /* ALL HEADINGS - Premium Gradient Styling */
    .contacts-page h1,
    .contacts-page h2,
    .contacts-page h3,
    .contacts-page h4,
    .contacts-page h5,
    .contacts-page h6 {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #06b6d4 100%) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        background-clip: text !important;
        font-weight: 700 !important;
        text-shadow: 0 2px 4px rgba(30, 64, 175, 0.2) !important;
        margin-bottom: 1rem !important;
        letter-spacing: -0.025em !important;
    }
    
    /* ALL PARAGRAPHS - Enhanced Typography */
    .contacts-page p {
        color: #1f2937 !important;
        font-size: 15px !important;
        line-height: 1.7 !important;
        font-weight: 500 !important;
        margin-bottom: 1.25rem !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
    }
    
    /* ALL CARDS - Premium Professional Design */
    .contacts-page .card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
        border: 2px solid transparent !important;
        border-radius: 16px !important;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 10px 15px rgba(0, 0, 0, 0.1) !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        position: relative !important;
        overflow: hidden !important;
    }
    
    .contacts-page .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, #3b82f6, #06b6d4, #10b981, #f59e0b);
        padding: 2px;
        border-radius: 16px;
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask-composite: exclude;
        z-index: -1;
    }
    
    .contacts-page .card:hover {
        transform: translateY(-8px) !important;
        box-shadow: 0 20px 25px rgba(0, 0, 0, 0.1), 0 10px 10px rgba(0, 0, 0, 0.04) !important;
    }
    
    /* ALL CONTACT ITEMS - Spectacular Enhancement */
    .contacts-page .contact-item {
        background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%) !important;
        border: 2px solid transparent !important;
        border-radius: 20px !important;
        padding: 2.5rem !important;
        margin-bottom: 2.5rem !important;
        box-shadow: 0 8px 15px rgba(59, 130, 246, 0.1), 0 4px 6px rgba(0, 0, 0, 0.05) !important;
        position: relative !important;
        overflow: hidden !important;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .contacts-page .contact-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, #3b82f6, #06b6d4, #10b981);
        padding: 2px;
        border-radius: 20px;
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask-composite: exclude;
        z-index: -1;
    }
    
    .contacts-page .contact-item:hover {
        transform: translateY(-10px) scale(1.02) !important;
        box-shadow: 0 25px 50px rgba(59, 130, 246, 0.25) !important;
    }
    
    /* Contact Subject Titles - Spectacular Prominence */
    .contacts-page .contact-item h5,
    .contacts-page .contact-item h6 {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #06b6d4 100%) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        background-clip: text !important;
        font-size: 22px !important;
        font-weight: 800 !important;
        line-height: 1.2 !important;
        margin-bottom: 1rem !important;
        letter-spacing: -0.05em !important;
        font-family: 'Inter', 'Segoe UI', system-ui, sans-serif !important;
        animation: titleShimmer 4s ease-in-out infinite alternate !important;
    }
    
    /* ALL MESSAGE CONTENT - Spectacular Design */
    .contacts-page .message-content {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 50%, #93c5fd 100%) !important;
        border: 3px solid transparent !important;
        border-radius: 16px !important;
        padding: 2rem !important;
        margin: 2rem 0 !important;
        position: relative !important;
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15) !important;
        transition: all 0.3s ease !important;
    }
    
    .contacts-page .message-content::before {
        content: '💬';
        position: absolute;
        top: -12px;
        left: 20px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
    }
    
    .contacts-page .message-content:hover {
        transform: scale(1.02) !important;
        box-shadow: 0 12px 35px rgba(59, 130, 246, 0.25) !important;
    }
    
    .contacts-page .message-content p {
        background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        background-clip: text !important;
        font-size: 16px !important;
        line-height: 1.8 !important;
        margin-bottom: 0 !important;
        font-weight: 600 !important;
        letter-spacing: 0.025em !important;
    }
    
    /* ALL RESPONSE ITEMS - Spectacular Enhancement */
    .contacts-page .response-item {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 50%, #a7f3d0 100%) !important;
        border: 3px solid transparent !important;
        border-radius: 20px !important;
        padding: 2rem !important;
        margin: 2rem 0 !important;
        position: relative !important;
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.15) !important;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .contacts-page .response-item::before {
        content: '👨‍💼 ADMIN RESPONSE';
        position: absolute;
        top: -15px;
        left: 20px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .contacts-page .response-item:hover {
        transform: translateY(-8px) scale(1.02) !important;
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.25) !important;
    }
    
    .contacts-page .response-item p {
        background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        background-clip: text !important;
        font-size: 15px !important;
        line-height: 1.7 !important;
        font-weight: 600 !important;
        margin-bottom: 0 !important;
        letter-spacing: 0.025em !important;
    }
    
    /* Contact Meta Information - Professional Cards */
    .contacts-page .contact-meta {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 10px !important;
        padding: 1.5rem !important;
        margin-top: 1rem !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
    }
    
    .contacts-page .contact-meta div {
        color: #1a202c !important;
        font-weight: 500 !important;
        margin-bottom: 0.5rem !important;
    }
    
    .contacts-page .contact-meta small {
        color: #4a5568 !important;
        font-weight: 500 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        font-size: 11px !important;
    }
    
    /* PROFESSIONAL FORM CONTROLS - Enhanced Design */
    .contacts-page .form-control {
        background: #ffffff !important;
        border: 2px solid #e2e8f0 !important;
        color: #1a202c !important;
        border-radius: 10px !important;
        padding: 14px 18px !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        font-size: 15px !important;
        font-weight: 500 !important;
        line-height: 1.5 !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
    }
    
    .contacts-page .form-control:hover {
        border-color: #cbd5e0 !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    }
    
    .contacts-page .form-control:focus {
        background: #ffffff !important;
        border: 2px solid #3182ce !important;
        color: #1a202c !important;
        box-shadow: 0 0 0 4px rgba(49, 130, 206, 0.15), 0 2px 8px rgba(49, 130, 206, 0.1) !important;
        outline: none !important;
        transform: translateY(-1px) !important;
    }
    
    /* PROFESSIONAL PLACEHOLDERS - Enhanced Readability */
    .contacts-page .form-control::placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-style: normal !important;
        font-weight: 400 !important;
    }
    
    .contacts-page .form-control::-webkit-input-placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-style: normal !important;
        font-weight: 400 !important;
    }
    
    .contacts-page .form-control::-moz-placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-style: normal !important;
        font-weight: 400 !important;
    }
    
    .contacts-page .form-control:-ms-input-placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-style: normal !important;
        font-weight: 400 !important;
    }
    
    .contacts-page .form-control:-moz-placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-style: normal !important;
        font-weight: 400 !important;
    }
    
    .contacts-page .form-label {
        color: #2d3748 !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        margin-bottom: 10px !important;
        text-shadow: none !important;
        letter-spacing: 0.025em !important;
        display: block !important;
    }
    
    /* Professional Select Controls */
    .contacts-page select.form-control {
        background: #ffffff !important;
        background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="%23666" d="M2 0L0 2h4zm0 5L0 3h4z"/></svg>') !important;
        background-repeat: no-repeat !important;
        background-position: right 12px center !important;
        background-size: 12px !important;
        padding-right: 40px !important;
        cursor: pointer !important;
    }
    
    .contacts-page select.form-control option {
        background: #ffffff !important;
        color: #1a202c !important;
        padding: 8px 12px !important;
    }
    
    /* Professional Textarea Controls */
    .contacts-page textarea.form-control {
        min-height: 120px !important;
        resize: vertical !important;
        line-height: 1.6 !important;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
    }
    
    .contacts-page textarea.form-control:focus {
        min-height: 140px !important;
    }
    
    /* Professional Checkbox Controls */
    .contacts-page .form-check-input {
        width: 18px !important;
        height: 18px !important;
        border: 2px solid #e2e8f0 !important;
        border-radius: 4px !important;
        background-color: #ffffff !important;
        transition: all 0.2s ease !important;
    }
    
    .contacts-page .form-check-input:checked {
        background-color: #3182ce !important;
        border-color: #3182ce !important;
        box-shadow: 0 0 0 2px rgba(49, 130, 206, 0.2) !important;
    }
    
    .contacts-page .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.15) !important;
        border-color: #3182ce !important;
    }
    
    .contacts-page .form-check-label {
        color: #2d3748 !important;
        font-weight: 500 !important;
        font-size: 14px !important;
        line-height: 1.5 !important;
        margin-left: 8px !important;
    }
    
    /* Professional Form Validation */
    .contacts-page .form-control.is-invalid {
        border-color: #e53e3e !important;
        box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.15) !important;
    }
    
    .contacts-page .invalid-feedback {
        color: #e53e3e !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        margin-top: 6px !important;
    }
    
    .contacts-page .form-text {
        color: #718096 !important;
        font-size: 12px !important;
        margin-top: 6px !important;
        line-height: 1.4 !important;
    }
    
    /* IMPROVED SPACING - Classic Theme Contact Items */
    .contacts-page .contact-item {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        padding: 2rem !important;
        margin-bottom: 2rem !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
        transition: all 0.2s ease !important;
    }
    
    /* Enhanced spacing for contact content */
    .contacts-page .contact-item .row {
        margin: 0 !important;
    }
    
    .contacts-page .contact-item .col-md-8,
    .contacts-page .contact-item .col-md-4 {
        padding: 0 1rem !important;
    }
    
    .contacts-page .contact-item:hover {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
        transform: translateY(-2px) !important;
        border-color: #3182ce !important;
    }
    
    .contacts-page .response-item {
        background: #f7fafc !important;
        border-left: 4px solid #3182ce !important;
        border-radius: 8px !important;
        padding: 1.25rem !important;
        margin-bottom: 1rem !important;
        margin-top: 0.75rem !important;
    }
    
    .contacts-page .contact-meta {
        background: #f7fafc !important;
        border-radius: 8px !important;
        padding: 1.5rem !important;
        margin-top: 1rem !important;
    }
    
    /* SPECIALIZED STATISTICS - Professional Data Display */
    .contacts-page .stat-item {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
        border: 2px solid #e2e8f0 !important;
        border-radius: 12px !important;
        padding: 2rem 1rem !important;
        text-align: center !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        margin-bottom: 1.5rem !important;
        position: relative !important;
        overflow: hidden !important;
    }
    
    .contacts-page .stat-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #3182ce 0%, #1d4ed8 100%);
    }
    
    .contacts-page .stat-item:hover {
        transform: translateY(-4px) !important;
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.15) !important;
        border-color: #3182ce !important;
    }
    
    .contacts-page .stat-item .h5 {
        color: #1a202c !important;
        font-weight: 800 !important;
        font-size: 2rem !important;
        margin-bottom: 0.5rem !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1) !important;
    }
    
    /* Specialized Stat Labels */
    .contacts-page .stat-item small {
        color: #374151 !important;
        font-weight: 600 !important;
        font-size: 11px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.1em !important;
        background: rgba(49, 130, 206, 0.1) !important;
        padding: 4px 12px !important;
        border-radius: 20px !important;
        display: inline-block !important;
        margin-top: 0.5rem !important;
    }
    
    .contacts-page .stat-item:hover {
        border-color: #3182ce !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    }
    
    .contacts-page .stat-item .h5 {
        color: #1a202c !important;  /* Clean dark for numbers */
        font-weight: 700 !important;
        font-size: 1.5rem !important;
        margin-bottom: 0.25rem !important;
    }
    
    /* Clean colors for stat labels */
    .contacts-page .stat-item small {
        color: #4a5568 !important;  /* Medium contrast for labels */
        font-weight: 500 !important;
        font-size: 12px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
    }
    
    /* SPECIALIZED BADGES - Professional Priority & Status Indicators */
    .contacts-page .badge {
        font-weight: 600 !important;
        padding: 0.5rem 1rem !important;
        border-radius: 20px !important;
        font-size: 11px !important;
        margin-right: 0.5rem !important;
        margin-bottom: 0.5rem !important;
        display: inline-flex !important;
        align-items: center !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        border: 1px solid transparent !important;
        transition: all 0.2s ease !important;
    }
    
    /* Priority Badge Styling */
    .contacts-page .badge.bg-danger {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%) !important;
        color: #dc2626 !important;
        border-color: #fca5a5 !important;
    }
    
    .contacts-page .badge.bg-warning {
        background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important;
        color: #d97706 !important;
        border-color: #fcd34d !important;
    }
    
    .contacts-page .badge.bg-info {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%) !important;
        color: #2563eb !important;
        border-color: #93c5fd !important;
    }
    
    .contacts-page .badge.bg-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%) !important;
        color: #059669 !important;
        border-color: #6ee7b7 !important;
    }
    
    .contacts-page .badge.bg-secondary {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important;
        color: #475569 !important;
        border-color: #cbd5e1 !important;
    }
    
    /* Badge container spacing */
    .contacts-page .d-flex.gap-2 {
        gap: 0.5rem !important;
        margin-bottom: 1rem !important;
        flex-wrap: wrap !important;
        align-items: center !important;
    }
    
    .contacts-page .badge.bg-primary {
        background-color: #3182ce !important;
        color: #ffffff !important;
    }
    
    .contacts-page .badge.bg-success {
        background-color: #38a169 !important;
        color: #ffffff !important;
    }
    
    .contacts-page .badge.bg-warning {
        background-color: #d69e2e !important;
        color: #ffffff !important;
    }
    
    .contacts-page .badge.bg-danger {
        background-color: #e53e3e !important;
        color: #ffffff !important;
    }
    
    .contacts-page .badge.bg-info {
        background-color: #3182ce !important;
        color: #ffffff !important;
    }
    
    .contacts-page .badge.bg-secondary {
        background-color: #718096 !important;
        color: #ffffff !important;
    }
    
    /* PROFESSIONAL BUTTON CONTROLS - Enhanced Design */
    .contacts-page .btn {
        border-radius: 8px !important;
        font-weight: 500 !important;
        font-size: 14px !important;
        padding: 10px 20px !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        border-width: 2px !important;
        letter-spacing: 0.025em !important;
    }
    
    .contacts-page .btn-sm {
        padding: 6px 12px !important;
        font-size: 12px !important;
    }
    
    .contacts-page .btn-outline-primary {
        color: #3182ce !important;
        border-color: #3182ce !important;
        background: #ffffff !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
    }
    
    .contacts-page .btn-outline-primary:hover {
        background-color: #3182ce !important;
        border-color: #3182ce !important;
        color: #ffffff !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 8px rgba(49, 130, 206, 0.25) !important;
    }
    
    .contacts-page .btn-outline-secondary {
        color: #4a5568 !important;
        border-color: #4a5568 !important;
        background: #ffffff !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
    }
    
    .contacts-page .btn-outline-secondary:hover {
        background-color: #4a5568 !important;
        border-color: #4a5568 !important;
        color: #ffffff !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 8px rgba(74, 85, 104, 0.25) !important;
    }
    
    .contacts-page .btn-outline-success {
        color: #38a169 !important;
        border-color: #38a169 !important;
        background: #ffffff !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
    }
    
    .contacts-page .btn-outline-success:hover {
        background-color: #38a169 !important;
        border-color: #38a169 !important;
        color: #ffffff !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 8px rgba(56, 161, 105, 0.25) !important;
    }
    
    .contacts-page .btn-outline-warning {
        color: #d69e2e !important;
        border-color: #d69e2e !important;
        background: #ffffff !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
    }
    
    .contacts-page .btn-outline-warning:hover {
        background-color: #d69e2e !important;
        border-color: #d69e2e !important;
        color: #ffffff !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 8px rgba(214, 158, 46, 0.25) !important;
    }
    
    .contacts-page .btn-outline-danger {
        color: #e53e3e !important;
        border-color: #e53e3e !important;
        background: #ffffff !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
    }
    
    .contacts-page .btn-outline-danger:hover {
        background-color: #e53e3e !important;
        border-color: #e53e3e !important;
        color: #ffffff !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 8px rgba(229, 62, 62, 0.25) !important;
    }
    
    /* Professional Primary Buttons */
    .contacts-page .btn-primary {
        background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important;
        border: 2px solid #3182ce !important;
        color: #ffffff !important;
        box-shadow: 0 2px 4px rgba(49, 130, 206, 0.2) !important;
    }
    
    .contacts-page .btn-primary:hover {
        background: linear-gradient(135deg, #2c5aa0 0%, #2a4a8a 100%) !important;
        border-color: #2c5aa0 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 8px rgba(49, 130, 206, 0.3) !important;
    }
    
    /* Responsive styling for mobile devices */
    @media (max-width: 768px) {
        .contacts-page .form-control {
            font-size: 16px !important;
            padding: 14px 16px !important;
        }
        
        .contacts-page .form-control::placeholder {
            font-size: 14px !important;
        }
        
        .contacts-page .form-label {
            font-size: 14px !important;
            margin-bottom: 6px !important;
        }
        
        .modal .form-control {
            font-size: 16px !important;
            padding: 14px 16px !important;
        }
        
        .modal .form-control::placeholder {
            font-size: 14px !important;
        }
    }
    
    @media (max-width: 576px) {
        .contacts-page .form-control {
            padding: 16px !important;
        }
        
        .modal .form-control {
            padding: 16px !important;
        }
    }
    /* ALL ANIMATIONS - Spectacular Effects for Complete Page */
    @keyframes titleShimmer {
        0% {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        50% {
            background: linear-gradient(135deg, #06b6d4 0%, #10b981 50%, #1e40af 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        100% {
            background: linear-gradient(135deg, #10b981 0%, #1e40af 50%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    }
    
    @keyframes badgePulse {
        0% {
            transform: scale(1);
            filter: brightness(1);
        }
        100% {
            transform: scale(1.05);
            filter: brightness(1.1);
        }
    }
    
    @keyframes cardFloat {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-5px);
        }
    }
    
    /* ALL CONTENT GLOBAL ENHANCEMENT */
    .contacts-page .container-fluid {
        animation: cardFloat 6s ease-in-out infinite !important;
    }
    
    .contacts-page .card-header {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #bae6fd 100%) !important;
        border-bottom: 2px solid #3b82f6 !important;
        color: #1e40af !important;
        font-weight: 700 !important;
        padding: 1.5rem 2rem !important;
        border-radius: 16px 16px 0 0 !important;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15) !important;
    }
    
    .contacts-page .card-body {
        padding: 2.5rem !important;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
    }
    
    /* ALL LINKS - Enhanced Professional Styling */
    .contacts-page a {
        color: #3b82f6 !important;
        text-decoration: none !important;
        font-weight: 600 !important;
        transition: all 0.2s ease !important;
        position: relative !important;
    }
    
    .contacts-page a:hover {
        color: #1d4ed8 !important;
        transform: translateY(-1px) !important;
        text-shadow: 0 2px 4px rgba(59, 130, 246, 0.3) !important;
    }
    
    /* ALL SMALL TEXT - Professional Enhancement */
    .contacts-page small {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important;
        color: #374151 !important;
        padding: 4px 12px !important;
        border-radius: 15px !important;
        border: 1px solid #d1d5db !important;
        font-weight: 600 !important;
        font-size: 11px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        display: inline-block !important;
        margin: 2px !important;
    }
</style>
@endpush
@endsection
