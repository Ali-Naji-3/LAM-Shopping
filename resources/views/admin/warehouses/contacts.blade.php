@extends('admin.dashboard')

@section('content')
<div class="container-fluid contacts-page">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="
                background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #06b6d4 100%) !important;
                -webkit-background-clip: text !important;
                -webkit-text-fill-color: transparent !important;
                background-clip: text !important;
                font-weight: 800 !important;
                font-size: 2.5rem !important;
                text-shadow: 0 0 25px rgba(30, 64, 175, 0.4) !important;
                animation: titleShimmer 4s ease-in-out infinite alternate !important;
                line-height: 1.2 !important;
                letter-spacing: -0.03em !important;
            ">
                📞 Warehouse Contacts
            </h2>
            <p class="mb-0" style="color: #2d3748 !important; font-size: 16px !important; font-weight: 500 !important; line-height: 1.5 !important;">
                {{ $warehouse->name }} • {{ $warehouse->code }} • Contact Messages & Support
            </p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newContactModal"
                    style="background: linear-gradient(135deg, #3182ce 0%, #1e40af 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; transition: all 0.2s ease !important;"
                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <i class="bi bi-plus-lg me-2"></i>New Contact
            </button>
            <a href="{{ route('admin.warehouses.show', $warehouse) }}" class="btn btn-outline-info"
               style="color: #06b6d4 !important; border-color: #06b6d4 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#06b6d4 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#06b6d4 !important';">
                <i class="bi bi-building me-2"></i>Warehouse Details
            </a>
            <a href="{{ route('admin.warehouses.index') }}" class="btn btn-outline-secondary" 
               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                <i class="bi bi-arrow-left me-2"></i>Back to Warehouses
            </a>
        </div>
    </div>

    <!-- Warehouse Info Card -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border: 1px solid #e0f2fe !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-body" style="padding: 1.5rem !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important; margin-bottom: 4px !important;">
                        <i class="bi bi-building me-2" style="color: #3182ce !important;"></i>{{ $warehouse->name }}
                    </h5>
                    <div style="color: #4a5568 !important; font-size: 14px !important;">
                        <span class="badge" style="background: #3182ce !important; color: #ffffff !important; font-size: 11px !important; padding: 4px 8px !important; border-radius: 12px !important; font-family: monospace !important; margin-right: 8px !important;">
                            {{ $warehouse->code }}
                        </span>
                        <i class="bi bi-geo-alt me-1" style="color: #f59e0b !important;"></i>{{ $warehouse->location }}
                        @if($warehouse->manager)
                            • <i class="bi bi-person me-1" style="color: #8b5cf6 !important;"></i>{{ $warehouse->manager }}
                        @endif
                    </div>
                </div>
                <div class="contact-stats" style="text-align: center !important;">
                    <div style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">{{ $contacts->total() }}</div>
                    <div style="color: #4a5568 !important; font-size: 12px !important; text-transform: uppercase !important; letter-spacing: 0.5px !important;">Total Contacts</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Messages -->
    @if($contacts->count() > 0)
        @foreach($contacts as $contact)
            <div class="contact-item" style="
                background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important;
                border: 2px solid transparent !important;
                background-clip: padding-box !important;
                position: relative !important;
                padding: 2.5rem !important;
                margin-bottom: 2rem !important;
                border-radius: 15px !important;
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            ">
                <!-- Contact Header -->
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="flex-grow-1">
                        <h5 style="color: #1a202c !important; font-weight: 700 !important; font-size: 1.5rem !important; margin-bottom: 0.5rem !important; line-height: 1.3 !important;">
                            {{ $contact->subject }}
                        </h5>
                        <div class="contact-meta" style="color: #4a5568 !important; font-size: 14px !important; line-height: 1.5 !important;">
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                @if($contact->user)
                                    <span><i class="bi bi-person me-1" style="color: #3182ce !important;"></i><strong>{{ $contact->user->name }}</strong></span>
                                @endif
                                <span><i class="bi bi-tag me-1" style="color: #10b981 !important;"></i>{{ ucfirst($contact->contact_type) }}</span>
                                <span><i class="bi bi-flag me-1" style="color: #f59e0b !important;"></i>{{ ucfirst($contact->priority) }} Priority</span>
                                <span style="color: #718096 !important; font-family: 'Courier New', monospace !important; font-size: 13px !important; background: #ffffff !important; padding: 4px 8px !important; border-radius: 8px !important; border: 1px solid #e2e8f0 !important;">
                                    <i class="bi bi-calendar me-1"></i>{{ $contact->created_at->format('M d, Y \a\t g:i A') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="contact-status">
                        <span class="badge" style="
                            background: linear-gradient(135deg, 
                                {{ $contact->status === 'pending' ? '#fbbf24, #f59e0b' : ($contact->status === 'resolved' ? '#10b981, #059669' : '#ef4444, #dc2626') }}
                            ) !important;
                            color: #ffffff !important;
                            font-size: 12px !important;
                            padding: 8px 16px !important;
                            border-radius: 25px !important;
                            text-transform: uppercase !important;
                            font-weight: 700 !important;
                            letter-spacing: 0.5px !important;
                            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2) !important;
                            animation: badgePulse 3s ease-in-out infinite !important;
                        ">
                            {{ $contact->status }}
                        </span>
                    </div>
                </div>

                <!-- Contact Message -->
                <div class="contact-message" style="
                    background: #ffffff !important;
                    padding: 2rem !important;
                    border-radius: 12px !important;
                    border: 1px solid #e2e8f0 !important;
                    margin-bottom: 1.5rem !important;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
                ">
                    <p style="color: #1a202c !important; font-size: 15px !important; line-height: 1.7 !important; margin: 0 !important; font-weight: 500 !important;">
                        {{ $contact->message }}
                    </p>
                </div>

                <!-- Contact Responses -->
                @if($contact->responses && $contact->responses->count() > 0)
                    <div class="responses-section">
                        <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 1rem !important;">
                            <i class="bi bi-chat-dots me-2" style="color: #8b5cf6 !important;"></i>Responses ({{ $contact->responses->count() }})
                        </h6>
                        @foreach($contact->responses as $response)
                            <div class="response-item" style="
                                background: #ffffff !important;
                                padding: 1.5rem !important;
                                border-radius: 10px !important;
                                border-left: 4px solid #8b5cf6 !important;
                                margin-bottom: 1rem !important;
                                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
                            ">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">
                                        Admin Response
                                    </div>
                                    <div style="color: #718096 !important; font-size: 12px !important; font-family: 'Courier New', monospace !important;">
                                        {{ $response->created_at->format('M d, Y \a\t g:i A') }}
                                    </div>
                                </div>
                                <p style="color: #1a202c !important; font-size: 14px !important; line-height: 1.6 !important; margin: 0 !important;">
                                    {{ $response->response }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Quick Actions -->
                <div class="contact-actions d-flex gap-2 mt-3">
                    <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#respondModal{{ $contact->id }}"
                            style="color: #10b981 !important; border-color: #10b981 !important; padding: 8px 16px !important; border-radius: 8px !important; font-size: 13px !important; font-weight: 600 !important;">
                        <i class="bi bi-reply me-1"></i>Respond
                    </button>
                    @if($contact->status === 'pending')
                        <form method="POST" action="{{ route('admin.contacts.updateStatus', $contact) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="resolved">
                            <button type="submit" class="btn btn-sm btn-outline-primary"
                                    style="color: #3182ce !important; border-color: #3182ce !important; padding: 8px 16px !important; border-radius: 8px !important; font-size: 13px !important; font-weight: 600 !important;">
                                <i class="bi bi-check-circle me-1"></i>Mark Resolved
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Response Modal -->
            <div class="modal fade" id="respondModal{{ $contact->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content" style="border-radius: 12px !important; border: none !important; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2) !important;">
                        <div class="modal-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                            <h5 class="modal-title" style="color: #1a202c !important; font-weight: 600 !important;">
                                <i class="bi bi-reply me-2" style="color: #10b981 !important;"></i>Respond to Contact
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="clearModalBackdrops();"></button>
                        </div>
                        <form method="POST" action="{{ route('admin.contacts.respond', $contact) }}">
                            @csrf
                            <div class="modal-body" style="padding: 2rem !important;">
                                <div class="mb-3">
                                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Original Message:</label>
                                    <div style="background: #f8fafc !important; padding: 1rem !important; border-radius: 8px !important; border-left: 4px solid #3182ce !important;">
                                        <p style="color: #1a202c !important; font-size: 14px !important; margin: 0 !important;">{{ $contact->message }}</p>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="response{{ $contact->id }}" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Your Response:</label>
                                    <textarea name="response" id="response{{ $contact->id }}" class="form-control" rows="4" required
                                              style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; line-height: 1.5 !important; transition: all 0.2s ease !important; resize: vertical !important;"
                                              placeholder="Enter your response to this warehouse contact..."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer" style="background: #f8fafc !important; border-top: 1px solid #e2e8f0 !important; border-radius: 0 0 12px 12px !important; padding: 1.5rem 2rem !important;">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" onclick="clearModalBackdrops();"
                                        style="color: #4a5568 !important; border-color: #4a5568 !important; padding: 10px 20px !important; border-radius: 8px !important; font-weight: 600 !important;">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-success"
                                        style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; color: #ffffff !important; padding: 10px 20px !important; border-radius: 8px !important; font-weight: 600 !important;">
                                    <i class="bi bi-send me-2"></i>Send Response
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        @if($contacts->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4" style="padding: 1.5rem 2rem !important; background: #ffffff !important; border-radius: 12px !important; border: 1px solid #e2e8f0 !important;">
                <div style="color: #4a5568 !important; font-size: 14px !important; font-weight: 500 !important;">
                    Showing {{ $contacts->firstItem() }}-{{ $contacts->lastItem() }} of {{ $contacts->total() }}
                </div>
                <div>
                    {{ $contacts->links('vendor.pagination.custom') }}
                </div>
            </div>
        @endif
    @else
        <!-- No Contacts State -->
        <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
            <div class="card-body text-center" style="padding: 4rem !important;">
                <div style="color: #9ca3af !important; font-size: 4rem !important; margin-bottom: 2rem !important;">📞</div>
                <h4 style="color: #1a202c !important; font-weight: 600 !important; font-size: 24px !important; margin-bottom: 1rem !important;">
                    No Contact Messages
                </h4>
                <p style="color: #4a5568 !important; font-size: 16px !important; margin-bottom: 2rem !important; max-width: 500px !important; margin-left: auto !important; margin-right: auto !important; line-height: 1.6 !important;">
                    This warehouse hasn't received any contact messages yet. Customers and staff can send inquiries about:
                </p>
                
                <div class="row justify-content-center mb-4">
                    <div class="col-md-8">
                        <div class="features-grid" style="text-align: left !important;">
                            <div class="feature-item" style="padding: 1rem !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 8px !important; margin-bottom: 1rem !important; border-left: 4px solid #3182ce !important;">
                                <div style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 4px !important;">
                                    <i class="bi bi-box me-2" style="color: #3182ce !important;"></i>Inventory Inquiries
                                </div>
                                <div style="color: #4a5568 !important; font-size: 13px !important;">Questions about stock levels, product availability, and inventory status</div>
                            </div>
                            <div class="feature-item" style="padding: 1rem !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 8px !important; margin-bottom: 1rem !important; border-left: 4px solid #10b981 !important;">
                                <div style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 4px !important;">
                                    <i class="bi bi-truck me-2" style="color: #10b981 !important;"></i>Shipping & Delivery
                                </div>
                                <div style="color: #4a5568 !important; font-size: 13px !important;">Delivery schedules, shipping arrangements, and logistics coordination</div>
                            </div>
                            <div class="feature-item" style="padding: 1rem !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 8px !important; margin-bottom: 1rem !important; border-left: 4px solid #f59e0b !important;">
                                <div style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 4px !important;">
                                    <i class="bi bi-tools me-2" style="color: #f59e0b !important;"></i>Facility Issues
                                </div>
                                <div style="color: #4a5568 !important; font-size: 13px !important;">Maintenance requests, facility problems, and operational issues</div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newContactModal"
                        style="background: linear-gradient(135deg, #3182ce 0%, #1e40af 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 24px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 16px !important;">
                    <i class="bi bi-plus-lg me-2"></i>Create First Contact
                </button>
            </div>
        </div>
    @endif

    <!-- New Contact Modal -->
    <div class="modal fade" id="newContactModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 12px !important; border: none !important; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2) !important;">
                <div class="modal-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="modal-title" style="color: #1a202c !important; font-weight: 600 !important;">
                        <i class="bi bi-plus-circle me-2" style="color: #3182ce !important;"></i>New Warehouse Contact
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="clearModalBackdrops();"></button>
                </div>
                <form method="POST" action="{{ route('admin.contacts.store') }}">
                    @csrf
                    <input type="hidden" name="warehouse_id" value="{{ $warehouse->id }}">
                    <div class="modal-body" style="padding: 2rem !important;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Subject <span style="color: #e53e3e !important;">*</span></label>
                                    <input type="text" name="subject" class="form-control" required
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important;"
                                           placeholder="Enter contact subject">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Contact Type</label>
                                    <select name="contact_type" class="form-control"
                                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important;">
                                        <option value="inquiry">Inquiry</option>
                                        <option value="support">Support</option>
                                        <option value="complaint">Complaint</option>
                                        <option value="feedback">Feedback</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Priority</label>
                                    <select name="priority" class="form-control"
                                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important;">
                                        <option value="low">Low</option>
                                        <option value="medium" selected>Medium</option>
                                        <option value="high">High</option>
                                        <option value="urgent">Urgent</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Status</label>
                                    <select name="status" class="form-control"
                                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important;">
                                        <option value="pending" selected>Pending</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="resolved">Resolved</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Message <span style="color: #e53e3e !important;">*</span></label>
                            <textarea name="message" class="form-control" rows="4" required
                                      style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; line-height: 1.5 !important; resize: vertical !important;"
                                      placeholder="Enter your warehouse contact message..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="background: #f8fafc !important; border-top: 1px solid #e2e8f0 !important; border-radius: 0 0 12px 12px !important; padding: 1.5rem 2rem !important;">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" onclick="clearModalBackdrops();"
                                style="color: #4a5568 !important; border-color: #4a5568 !important; padding: 10px 20px !important; border-radius: 8px !important; font-weight: 600 !important;">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary"
                                style="background: linear-gradient(135deg, #3182ce 0%, #1e40af 100%) !important; border: none !important; color: #ffffff !important; padding: 10px 20px !important; border-radius: 8px !important; font-weight: 600 !important;">
                            <i class="bi bi-send me-2"></i>Send Contact
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* CLEAN WAREHOUSE CONTACTS - Professional Styling */
    @keyframes titleShimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    
    @keyframes badgePulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    @keyframes cardFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-2px); }
    }
    
    .contacts-page {
        animation: cardFloat 6s ease-in-out infinite;
    }
    
    .contact-item {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .contact-item:hover {
        transform: translateY(-4px) !important;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2) !important;
        border-color: #3182ce !important;
    }
    
    .feature-item {
        transition: all 0.2s ease !important;
    }
    
    .feature-item:hover {
        transform: translateX(4px) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }
    
    .response-item {
        transition: all 0.2s ease !important;
    }
    
    .response-item:hover {
        transform: translateX(2px) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }
    
    .form-control::placeholder {
        color: #9ca3af !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    
    .form-control::-webkit-input-placeholder { color: #9ca3af !important; opacity: 1 !important; }
    .form-control::-moz-placeholder { color: #9ca3af !important; opacity: 1 !important; }
    .form-control:-ms-input-placeholder { color: #9ca3af !important; opacity: 1 !important; }
    .form-control:-moz-placeholder { color: #9ca3af !important; opacity: 1 !important; }
</style>
@endpush

@push('scripts')
<script>
    // Clear modal backdrops function (optimized to reduce console spam)
    window.clearModalBackdrops = function() {
        const backdrops = document.querySelectorAll('.modal-backdrop');
        if (backdrops.length > 0) {
            backdrops.forEach(backdrop => backdrop.remove());
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            console.log('Modal backdrops cleared');
        }
    };

    // Clear modal backdrops on page load and focus
    document.addEventListener('DOMContentLoaded', clearModalBackdrops);
    window.addEventListener('focus', clearModalBackdrops);
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            clearModalBackdrops();
        }
    });
</script>
@endpush
@endsection
