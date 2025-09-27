@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                📞 Review Contacts: {{ $review->title ?? 'Review #' . $review->id }}
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                Contact messages related to this review • {{ $contacts->total() }} total contacts
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-outline-primary"
               style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                <i class="bi bi-arrow-left me-2"></i>Back to Review
            </a>
        </div>
    </div>

    <!-- Review Info Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 style="color: #1a202c !important; font-weight: 700 !important; font-size: 20px !important; margin-bottom: 8px !important;">
                                Review: {{ $review->title ?? 'Review #' . $review->id }}
                            </h4>
                            <p style="color: #4a5568 !important; font-size: 14px !important; margin-bottom: 12px !important;">
                                {{ $review->comment ? Str::limit($review->comment, 150) : 'No comment available' }}
                            </p>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rating-stars" style="color: {{ $review->rating_color }} !important; font-size: 16px !important;">
                                    {{ $review->star_rating }}
                                </div>
                                <div style="color: #4a5568 !important; font-size: 14px !important;">
                                    Product: {{ $review->product->name ?? 'Unknown Product' }}
                                </div>
                                <div style="color: #4a5568 !important; font-size: 14px !important;">
                                    Reviewer: {{ $review->user->name ?? 'Unknown User' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="d-flex flex-column align-items-md-end">
                                <span class="badge" style="background: {{ $review->status_color }} !important; color: #ffffff !important; font-size: 12px !important; padding: 6px 12px !important; border-radius: 12px !important; margin-bottom: 8px !important;">
                                    {{ $review->status_badge }}
                                </span>
                                <div style="color: #4a5568 !important; font-size: 14px !important;">
                                    {{ $contactStats['total_contacts'] }} contacts
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Statistics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important; box-shadow: 0 4px 12px rgba(49, 130, 206, 0.3) !important;">
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-flex align-items-center">
                        <div style="background: rgba(255, 255, 255, 0.2) !important; border-radius: 50% !important; width: 50px !important; height: 50px !important; display: flex !important; align-items: center !important; justify-content: center !important; margin-right: 1rem !important;">
                            <i class="bi bi-chat-dots" style="font-size: 20px !important;"></i>
                        </div>
                        <div>
                            <h3 class="mb-0" style="color: #ffffff !important; font-weight: 700 !important; font-size: 28px !important;">{{ $contactStats['total_contacts'] }}</h3>
                            <p class="mb-0" style="color: rgba(255, 255, 255, 0.9) !important; font-size: 14px !important; font-weight: 500 !important;">Total Contacts</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3) !important;">
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-flex align-items-center">
                        <div style="background: rgba(255, 255, 255, 0.2) !important; border-radius: 50% !important; width: 50px !important; height: 50px !important; display: flex !important; align-items: center !important; justify-content: center !important; margin-right: 1rem !important;">
                            <i class="bi bi-clock" style="font-size: 20px !important;"></i>
                        </div>
                        <div>
                            <h3 class="mb-0" style="color: #ffffff !important; font-weight: 700 !important; font-size: 28px !important;">{{ $contactStats['pending_contacts'] }}</h3>
                            <p class="mb-0" style="color: rgba(255, 255, 255, 0.9) !important; font-size: 14px !important; font-weight: 500 !important;">Pending</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3) !important;">
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-flex align-items-center">
                        <div style="background: rgba(255, 255, 255, 0.2) !important; border-radius: 50% !important; width: 50px !important; height: 50px !important; display: flex !important; align-items: center !important; justify-content: center !important; margin-right: 1rem !important;">
                            <i class="bi bi-check-circle" style="font-size: 20px !important;"></i>
                        </div>
                        <div>
                            <h3 class="mb-0" style="color: #ffffff !important; font-weight: 700 !important; font-size: 28px !important;">{{ $contactStats['resolved_contacts'] }}</h3>
                            <p class="mb-0" style="color: rgba(255, 255, 255, 0.9) !important; font-size: 14px !important; font-weight: 500 !important;">Resolved</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;">
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-flex align-items-center">
                        <div style="background: rgba(255, 255, 255, 0.2) !important; border-radius: 50% !important; width: 50px !important; height: 50px !important; display: flex !important; align-items: center !important; justify-content: center !important; margin-right: 1rem !important;">
                            <i class="bi bi-exclamation-triangle" style="font-size: 20px !important;"></i>
                        </div>
                        <div>
                            <h3 class="mb-0" style="color: #ffffff !important; font-weight: 700 !important; font-size: 28px !important;">{{ $contactStats['high_priority_contacts'] }}</h3>
                            <p class="mb-0" style="color: rgba(255, 255, 255, 0.9) !important; font-size: 14px !important; font-weight: 500 !important;">High Priority</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Contact Form -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-plus-circle me-2" style="color: #3182ce !important;"></i>New Contact Message
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <form method="POST" action="{{ route('admin.reviews.contacts.store', $review) }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="subject" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                    Subject <span style="color: #e53e3e !important;">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('subject') is-invalid @enderror" 
                                       id="subject" 
                                       name="subject" 
                                       value="{{ old('subject') }}"
                                       required
                                       style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                       placeholder="Enter contact subject">
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label for="contact_type" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                    Type <span style="color: #e53e3e !important;">*</span>
                                </label>
                                <select class="form-control @error('contact_type') is-invalid @enderror" 
                                        id="contact_type" 
                                        name="contact_type" 
                                        required
                                        style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                                    <option value="">Select type...</option>
                                    <option value="inquiry" {{ old('contact_type') == 'inquiry' ? 'selected' : '' }}>Inquiry</option>
                                    <option value="complaint" {{ old('contact_type') == 'complaint' ? 'selected' : '' }}>Complaint</option>
                                    <option value="suggestion" {{ old('contact_type') == 'suggestion' ? 'selected' : '' }}>Suggestion</option>
                                    <option value="other" {{ old('contact_type') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('contact_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label for="priority" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                    Priority <span style="color: #e53e3e !important;">*</span>
                                </label>
                                <select class="form-control @error('priority') is-invalid @enderror" 
                                        id="priority" 
                                        name="priority" 
                                        required
                                        style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                                    <option value="">Select priority...</option>
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Message <span style="color: #e53e3e !important;">*</span>
                            </label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" 
                                      name="message" 
                                      rows="4"
                                      required
                                      style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; line-height: 1.6 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important; resize: vertical !important;"
                                      placeholder="Enter your message...">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" 
                                    style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: 2px solid #3182ce !important; color: #ffffff !important; padding: 14px 24px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; box-shadow: 0 2px 4px rgba(49, 130, 206, 0.2) !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.background='linear-gradient(135deg, #2c5aa0 0%, #2a4a8a 100%) !important'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
                                    onmouseout="this.style.background='linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(49, 130, 206, 0.2) !important';">
                                <i class="bi bi-send me-2"></i>Send Contact Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Contacts List -->
    <div class="row">
        @forelse($contacts as $contact)
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important; height: 100% !important;"
                     onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.1) !important'; this.style.borderColor='#3182ce !important';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1) !important'; this.style.borderColor='#e2e8f0 !important';">
                    
                    <div class="card-body" style="padding: 1.5rem !important;">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 4px !important;">
                                    {{ $contact->subject }}
                                </h6>
                                <div class="d-flex gap-2">
                                    <span class="badge" style="background: {{ $contact->status == 'pending' ? '#f59e0b' : '#10b981' }} !important; color: #ffffff !important; font-size: 10px !important; padding: 4px 8px !important; border-radius: 12px !important;">
                                        {{ ucfirst($contact->status) }}
                                    </span>
                                    <span class="badge" style="background: {{ $contact->priority == 'urgent' ? '#ef4444' : ($contact->priority == 'high' ? '#f59e0b' : ($contact->priority == 'medium' ? '#3182ce' : '#10b981')) }} !important; color: #ffffff !important; font-size: 10px !important; padding: 4px 8px !important; border-radius: 12px !important;">
                                        {{ ucfirst($contact->priority) }}
                                    </span>
                                    <span class="badge" style="background: #6b7280 !important; color: #ffffff !important; font-size: 10px !important; padding: 4px 8px !important; border-radius: 12px !important;">
                                        {{ ucfirst($contact->contact_type) }}
                                    </span>
                                </div>
                            </div>
                            <small style="color: #718096 !important; font-size: 12px !important;">{{ $contact->created_at->format('M d, Y') }}</small>
                        </div>

                        <p style="color: #4a5568 !important; font-size: 14px !important; line-height: 1.6 !important; margin-bottom: 12px !important;">
                            {{ Str::limit($contact->message, 150) }}
                        </p>

                        <div style="padding: 10px !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 8px !important;">
                            <div style="color: #718096 !important; font-size: 12px !important;">
                                <strong>From:</strong> {{ $contact->user->name ?? 'Unknown User' }}<br>
                                <strong>Contact ID:</strong> #{{ $contact->id }}
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-sm btn-outline-primary"
                                   style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 6px 12px !important; border-radius: 6px !important; font-weight: 500 !important; font-size: 12px !important; border-width: 1px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                                   onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                                   onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                                    <i class="bi bi-eye me-1"></i>View
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-secondary"
                                   style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 6px 12px !important; border-radius: 6px !important; font-weight: 500 !important; font-size: 12px !important; border-width: 1px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                                   onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
                                   onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                                    <i class="bi bi-reply me-1"></i>Reply
                                </a>
                            </div>
                            
                            @if($contact->status == 'pending')
                                <form method="POST" action="#" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success"
                                            style="padding: 6px 12px !important; border-radius: 6px !important; font-weight: 500 !important; font-size: 12px !important; border-width: 1px !important; transition: all 0.2s ease !important;"
                                            onmouseover="this.style.transform='translateY(-1px)';"
                                            onmouseout="this.style.transform='translateY(0)';">
                                        <i class="bi bi-check-circle me-1"></i>Resolve
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-body" style="padding: 3rem !important; text-align: center !important;">
                        <i class="bi bi-chat-dots" style="font-size: 48px !important; color: #cbd5e0 !important; margin-bottom: 1rem !important;"></i>
                        <h5 style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important; margin-bottom: 8px !important;">No Contacts Found</h5>
                        <p style="color: #718096 !important; font-size: 14px !important; margin-bottom: 0 !important;">No contact messages have been sent for this review yet.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($contacts->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $contacts->links() }}
        </div>
    @endif
</div>

@push('styles')
<style>
    /* CLEAN REVIEW CONTACTS - Professional Styling */
    .card {
        transition: all 0.2s ease !important;
    }
    
    .btn-sm {
        transition: all 0.2s ease !important;
    }
    
    .btn-sm:hover {
        transform: translateY(-1px) !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem !important;
        }
        
        .d-flex.gap-2 {
            flex-direction: column !important;
            gap: 8px !important;
        }
    }
</style>
@endpush
@endsection
