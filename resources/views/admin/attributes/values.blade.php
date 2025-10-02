@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important;">
                📋 {{ $attribute->name }} - Values
            </h2>
            <p class="text-muted mb-0" style="color: #4a5568 !important;">Manage attribute values for {{ $attribute->name }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.attributes.show', $attribute) }}" class="btn btn-outline-secondary"
               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; text-decoration: none !important;">
                <i class="bi bi-arrow-left me-2"></i>Back to Attribute
            </a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addValueModal"
                    style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 24px !important; border-radius: 10px !important; font-weight: 600 !important;">
                <i class="bi bi-plus-circle me-2"></i>Add Value
            </button>
        </div>
    </div>

    <!-- Values List -->
    <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-body" style="padding: 2rem !important;">
            @if($values->count() > 0)
                <div class="row">
                    @foreach($values as $value)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                            <div class="value-card" 
                                 style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 10px !important; padding: 1.5rem !important; transition: all 0.2s ease !important;"
                                 onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(49, 130, 206, 0.1) !important'; this.style.borderColor='#3182ce !important';"
                                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.borderColor='#e2e8f0 !important';">
                                
                                @if($attribute->name === 'Color' && in_array(strtolower($value->value), ['red', 'blue', 'green', 'black', 'white', 'yellow', 'pink', 'purple', 'orange', 'brown', 'gray']))
                                    <!-- Color Display -->
                                    <div class="text-center mb-3">
                                        <div class="color-swatch" style="width: 40px !important; height: 40px !important; border-radius: 50% !important; background-color: {{ strtolower($value->value) === 'black' ? '#000000' : (strtolower($value->value) === 'white' ? '#ffffff' : strtolower($value->value)) }} !important; border: 2px solid #e2e8f0 !important; margin: 0 auto !important; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;"></div>
                                    </div>
                                @else
                                    <!-- Regular Value Display -->
                                    <div class="text-center mb-3">
                                        <i class="bi bi-{{ $attribute->type === 'select' ? 'list-ul' : ($attribute->type === 'checkbox' ? 'check-square' : 'circle') }}" 
                                           style="color: {{ $attribute->type === 'select' ? '#10b981' : ($attribute->type === 'checkbox' ? '#f59e0b' : '#8b5cf6') }} !important; font-size: 24px !important;"></i>
                                    </div>
                                @endif
                                
                                <div class="text-center">
                                    <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        {{ $value->value }}
                                    </h6>
                                    <small style="color: #718096 !important; font-size: 11px !important;">
                                        Added {{ $value->created_at->format('M d, Y') }}
                                    </small>
                                </div>
                                
                                <div class="d-flex gap-1 mt-3">
                                    <button class="btn btn-sm btn-outline-primary flex-fill" 
                                            style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 6px 12px !important; border-radius: 6px !important; font-size: 12px !important;"
                                            onclick="editValue({{ $value->id }}, '{{ $value->value }}')">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.attributeValues.destroy', $value) }}" class="d-inline flex-fill"
                                          onsubmit="return confirm('Are you sure you want to delete this value?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100"
                                                style="color: #e53e3e !important; border-color: #e53e3e !important; background: #ffffff !important; padding: 6px 12px !important; border-radius: 6px !important; font-size: 12px !important;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-container mt-4" style="background: white; padding: 12px 20px; border-radius: 8px; border: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
                    <div class="pagination-info" style="color: #6c757d; font-weight: 400; font-size: 14px;">
                        Showing {{ $values->firstItem() ?? 0 }} to {{ $values->lastItem() ?? 0 }} of {{ $values->total() }} values
                    </div>
                    <div class="pagination-links">
                        {{ $values->appends(request()->query())->links('pagination.custom') }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-list display-1" style="color: #718096 !important;"></i>
                    <h4 class="mt-3" style="color: #2d3748 !important;">No Values Found</h4>
                    <p style="color: #4a5568 !important;">Start by adding values for this attribute.</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addValueModal"
                            style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 24px !important; border-radius: 10px !important; font-weight: 600 !important;">
                        <i class="bi bi-plus-circle me-2"></i>Add First Value
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Value Modal -->
<div class="modal fade" id="addValueModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px !important; border: none !important; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important;">
                <h5 class="modal-title" style="color: #1a202c !important; font-weight: 700 !important;">
                    <i class="bi bi-plus-circle me-2" style="color: #3182ce !important;"></i>Add New Value
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.attributeValues.store') }}">
                @csrf
                <input type="hidden" name="attribute_id" value="{{ $attribute->id }}">
                <div class="modal-body" style="padding: 2rem !important;">
                    <div class="mb-3">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important;">Value</label>
                        <input type="text" name="value" class="form-control" required
                               style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 12px 16px !important; border-radius: 8px !important; font-size: 14px !important;"
                               placeholder="Enter attribute value...">
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e2e8f0 !important; padding: 1.5rem 2rem !important;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 10px 20px !important; border-radius: 8px !important; font-weight: 600 !important;">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary"
                            style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 10px 20px !important; border-radius: 8px !important; font-weight: 600 !important;">
                        Add Value
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Value Modal -->
<div class="modal fade" id="editValueModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px !important; border: none !important; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important;">
                <h5 class="modal-title" style="color: #1a202c !important; font-weight: 700 !important;">
                    <i class="bi bi-pencil me-2" style="color: #3182ce !important;"></i>Edit Value
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editValueForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body" style="padding: 2rem !important;">
                    <div class="mb-3">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important;">Value</label>
                        <input type="text" name="value" id="editValueInput" class="form-control" required
                               style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 12px 16px !important; border-radius: 8px !important; font-size: 14px !important;">
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e2e8f0 !important; padding: 1.5rem 2rem !important;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 10px 20px !important; border-radius: 8px !important; font-weight: 600 !important;">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary"
                            style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 10px 20px !important; border-radius: 8px !important; font-weight: 600 !important;">
                        Update Value
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function editValue(id, currentValue) {
    document.getElementById('editValueInput').value = currentValue;
    document.getElementById('editValueForm').action = `/admin/attributeValues/${id}`;
    new bootstrap.Modal(document.getElementById('editValueModal')).show();
}
</script>
@endpush

@push('styles')
<style>
.value-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

.color-swatch {
    transition: all 0.2s ease !important;
}

.value-card:hover .color-swatch {
    transform: scale(1.1) !important;
}

.form-control:focus {
    background: #ffffff !important;
    border: 2px solid #3182ce !important;
    color: #1a202c !important;
    box-shadow: 0 0 0 4px rgba(49, 130, 206, 0.15) !important;
    outline: none !important;
}

.btn {
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

.btn:hover {
    transform: translateY(-1px) !important;
}
</style>
@endpush
@endsection
