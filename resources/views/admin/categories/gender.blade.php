@extends('admin.dashboard')

@section('content')
<div class="container-fluid {{ $theme['theme_name'] }}">
    <!-- Gender-Themed Header -->
    <div class="gender-header mb-4">
        <div class="theme-gradient"></div>
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="header-content">
                    <h1 class="gender-title">
                        <span class="gender-icon">{{ $theme['icon'] }}</span>
                        {{ $theme['title'] }}
                    </h1>
                    <p class="gender-description">{{ $theme['description'] }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="gender-stats-summary">
                    <div class="stat-item">
                        <span class="stat-number">{{ $statistics['total_categories'] }}</span>
                        <span class="stat-label">Categories</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $statistics['total_products'] }}</span>
                        <span class="stat-label">Products</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $statistics['total_brands'] }}</span>
                        <span class="stat-label">Brands</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gender Switcher -->
    <div class="gender-switcher mb-4">
        <div class="switcher-container">
            <span class="switcher-label">Switch Gender:</span>
            <div class="gender-buttons">
                <a href="{{ route('admin.categories.men') }}" class="gender-btn men-theme {{ $gender === 'Men' ? 'active' : '' }}">
                    <span class="icon">👨</span>
                    <span>Men</span>
                    <span class="count">{{ $crossGenderStats['Men']['categories_count'] ?? 0 }}</span>
                </a>
                <a href="{{ route('admin.categories.women') }}" class="gender-btn women-theme {{ $gender === 'Women' ? 'active' : '' }}">
                    <span class="icon">👩</span>
                    <span>Women</span>
                    <span class="count">{{ $crossGenderStats['Women']['categories_count'] ?? 0 }}</span>
                </a>
                <a href="{{ route('admin.categories.boys') }}" class="gender-btn boys-theme {{ $gender === 'Boys' ? 'active' : '' }}">
                    <span class="icon">👦</span>
                    <span>Boys</span>
                    <span class="count">{{ $crossGenderStats['Boys']['categories_count'] ?? 0 }}</span>
                </a>
                <a href="{{ route('admin.categories.girls') }}" class="gender-btn girls-theme {{ $gender === 'Girls' ? 'active' : '' }}">
                    <span class="icon">👧</span>
                    <span>Girls</span>
                    <span class="count">{{ $crossGenderStats['Girls']['categories_count'] ?? 0 }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Dashboard -->
    <div class="row mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number">{{ $statistics['active_categories'] }}</div>
                    <div class="stats-label">Active Categories</div>
                    <div class="stats-sublabel">of {{ $statistics['total_categories'] }} total</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number">{{ $statistics['active_products'] }}</div>
                    <div class="stats-label">Active Products</div>
                    <div class="stats-sublabel">of {{ $statistics['total_products'] }} total</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number">{{ $statistics['pending_contacts'] }}</div>
                    <div class="stats-label">Pending Contacts</div>
                    <div class="stats-sublabel">of {{ $statistics['total_contacts'] }} total</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number">{{ number_format($statistics['average_rating'], 1) }}</div>
                    <div class="stats-label">Average Rating</div>
                    <div class="stats-sublabel">across all products</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="filters-section mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <form method="GET" class="row align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Search {{ $gender }} Categories</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Search categories..." 
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status Filter</label>
                        <select name="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.categories.' . strtolower($gender)) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.categories.create') }}?parent_id={{ $genderCategory->id }}" 
                           class="btn btn-success w-100">
                            <i class="fas fa-plus"></i> Add Category
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="categories-grid">
        <div class="row">
            @forelse($categories as $category)
                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                    <div class="category-card">
                        <div class="card-header">
                            <div class="category-info">
                                <h5 class="category-name">{{ $category->name }}</h5>
                                <span class="category-status {{ $category->is_active ? 'active' : 'inactive' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            @if($category->image)
                                <div class="category-image">
                                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}">
                                </div>
                            @endif
                        </div>
                        
                        <div class="card-body">
                            @if($category->description)
                                <p class="category-description">{{ Str::limit($category->description, 100) }}</p>
                            @endif
                            
                            <div class="category-stats">
                                <div class="stat">
                                    <i class="fas fa-box"></i>
                                    <span>{{ $category->products_count }} Products</span>
                                </div>
                                <div class="stat">
                                    <i class="fas fa-envelope"></i>
                                    <span>{{ $category->contacts_count }} Contacts</span>
                                </div>
                                @if($category->children_count > 0)
                                    <div class="stat">
                                        <i class="fas fa-layer-group"></i>
                                        <span>{{ $category->children_count }} Subcategories</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <div class="category-actions">
                                <a href="{{ route('admin.categories.show', $category) }}" 
                                   class="btn btn-sm btn-info" title="View Details">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                   class="btn btn-sm btn-warning" title="Edit Category">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                @if($category->products_count == 0 && $category->children_count == 0)
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" 
                                          class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete Category">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled title="Cannot delete: has products or subcategories">
                                        <i class="fas fa-lock"></i> Protected
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <div class="empty-icon">{{ $theme['icon'] }}</div>
                        <h4>No {{ $gender }} Categories Found</h4>
                        <p>Start by creating your first {{ strtolower($gender) }}'s category.</p>
                        <a href="{{ route('admin.categories.create') }}?parent_id={{ $genderCategory->id }}" 
                           class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create First Category
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($categories->hasPages())
        <div class="pagination-wrapper">
            {{ $categories->appends(request()->query())->links('vendor.pagination.custom') }}
        </div>
    @endif
</div>

@push('styles')
<style>
/* Gender Theme Variables */
:root {
    --theme-primary: {{ $theme['theme_color'] }};
    --theme-primary-rgb: {{ $this->hexToRgb($theme['theme_color']) }};
    --theme-light: {{ $theme['theme_color'] }}20;
    --theme-gradient: linear-gradient(135deg, {{ $theme['theme_color'] }} 0%, {{ $this->darkenColor($theme['theme_color'], 20) }} 100%);
}

/* Gender Header */
.gender-header {
    position: relative;
    background: var(--theme-gradient);
    border-radius: 16px;
    padding: 2rem;
    color: white;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(var(--theme-primary-rgb), 0.3);
}

.theme-gradient {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: var(--theme-gradient);
    opacity: 0.1;
}

.gender-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.gender-icon {
    font-size: 3rem;
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
}

.gender-description {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
}

.gender-stats-summary {
    display: flex;
    gap: 1.5rem;
    justify-content: flex-end;
}

.gender-stats-summary .stat-item {
    text-align: center;
    background: rgba(255,255,255,0.1);
    padding: 1rem;
    border-radius: 12px;
    backdrop-filter: blur(10px);
    min-width: 80px;
}

.gender-stats-summary .stat-number {
    display: block;
    font-size: 1.8rem;
    font-weight: 700;
    line-height: 1;
}

.gender-stats-summary .stat-label {
    display: block;
    font-size: 0.85rem;
    opacity: 0.8;
    margin-top: 0.25rem;
}

/* Gender Switcher */
.gender-switcher {
    background: white;
    border-radius: 12px;
    padding: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.switcher-container {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.switcher-label {
    font-weight: 600;
    color: #4a5568;
    white-space: nowrap;
}

.gender-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.gender-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.gender-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    text-decoration: none;
}

.gender-btn .icon {
    font-size: 1.2rem;
}

.gender-btn .count {
    background: rgba(255,255,255,0.2);
    padding: 0.2rem 0.5rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
}

/* Gender Button Themes */
.men-theme {
    background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%);
    color: white;
}

.women-theme {
    background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
    color: white;
}

.boys-theme {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.girls-theme {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    color: white;
}

.gender-btn.active {
    border-color: rgba(255,255,255,0.3);
    box-shadow: 0 0 0 3px rgba(255,255,255,0.1);
}

/* Statistics Cards */
.stats-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-left: 4px solid var(--theme-primary);
    transition: all 0.3s ease;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
}

.stats-card {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stats-icon {
    width: 60px;
    height: 60px;
    background: var(--theme-light);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--theme-primary);
    font-size: 1.5rem;
}

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    line-height: 1;
}

.stats-label {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0.25rem;
}

.stats-sublabel {
    font-size: 0.85rem;
    color: #718096;
}

/* Filters Section */
.filters-section .card {
    border-left: 4px solid var(--theme-primary);
}

.filters-section .form-label {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.filters-section .input-group-text {
    background: var(--theme-light);
    border-color: var(--theme-primary);
    color: var(--theme-primary);
}

.filters-section .form-control:focus {
    border-color: var(--theme-primary);
    box-shadow: 0 0 0 0.2rem rgba(var(--theme-primary-rgb), 0.25);
}

.btn-primary {
    background: var(--theme-primary);
    border-color: var(--theme-primary);
}

.btn-primary:hover {
    background: {{ $this->darkenColor($theme['theme_color'], 15) }};
    border-color: {{ $this->darkenColor($theme['theme_color'], 15) }};
}

/* Category Cards */
.category-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-left: 4px solid var(--theme-primary);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.category-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
}

.category-card .card-header {
    background: var(--theme-light);
    padding: 1rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.category-name {
    font-weight: 700;
    color: #2d3748;
    margin: 0;
    font-size: 1.1rem;
}

.category-status {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.category-status.active {
    background: #d1fae5;
    color: #065f46;
}

.category-status.inactive {
    background: #fee2e2;
    color: #991b1b;
}

.category-image img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
}

.category-card .card-body {
    padding: 1rem;
    flex: 1;
}

.category-description {
    color: #4a5568;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
}

.category-stats {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1rem;
}

.category-stats .stat {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    color: #4a5568;
}

.category-stats .stat i {
    color: var(--theme-primary);
    width: 16px;
}

.category-card .card-footer {
    background: #f8fafc;
    padding: 1rem;
    border-top: 1px solid #e2e8f0;
}

.category-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.category-actions .btn {
    font-size: 0.85rem;
    padding: 0.4rem 0.8rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state h4 {
    color: #2d3748;
    margin-bottom: 1rem;
}

.empty-state p {
    color: #718096;
    margin-bottom: 2rem;
}

/* Pagination */
.pagination-wrapper {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #e2e8f0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .gender-title {
        font-size: 2rem;
    }
    
    .gender-stats-summary {
        justify-content: center;
        margin-top: 1rem;
    }
    
    .switcher-container {
        flex-direction: column;
        align-items: stretch;
    }
    
    .gender-buttons {
        justify-content: center;
    }
    
    .stats-card {
        margin-bottom: 1rem;
    }
}

@media (max-width: 576px) {
    .gender-header {
        padding: 1.5rem;
    }
    
    .gender-title {
        font-size: 1.75rem;
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .gender-stats-summary {
        gap: 1rem;
    }
    
    .category-actions {
        justify-content: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Add any gender-specific JavaScript functionality here
document.addEventListener('DOMContentLoaded', function() {
    // Animate statistics on page load
    const statNumbers = document.querySelectorAll('.stats-number');
    statNumbers.forEach(stat => {
        const finalValue = parseInt(stat.textContent);
        let currentValue = 0;
        const increment = finalValue / 30;
        
        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= finalValue) {
                currentValue = finalValue;
                clearInterval(timer);
            }
            stat.textContent = Math.floor(currentValue);
        }, 50);
    });
    
    // Add ripple effect to cards
    const cards = document.querySelectorAll('.category-card, .stats-card');
    cards.forEach(card => {
        card.addEventListener('click', function(e) {
            const ripple = document.createElement('div');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255,255,255,0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});

// Add CSS animation for ripple effect
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush
@endsection
