# Product Form Components - Shared Partials

## Overview
These shared components ensure consistency across Create, Edit, and View pages. When you update a component, all pages using it are automatically updated.

## Available Components

### 1. `_basic_fields.blade.php`
**Contains:**
- Product Name (required)
- Slug (auto-generated)
- Category (required)
- Brand (optional)
- Description (optional)

**Used in:**
- `create.blade.php`
- `edit.blade.php`

**Parameters:**
```php
@include('admin.products.partials._basic_fields', [
    'product' => $product,        // null for create, $product for edit
    'categories' => $categories,  // All categories
    'brands' => $brands,          // All brands
    'readonly' => false           // Optional: true for view-only
])
```

### 2. `_price_fields.blade.php`
**Contains:**
- Regular Price (required) - Original/full price
- Sale Price (optional) - Discounted price
- Stock (required, min: 1)

**Used in:**
- `create.blade.php`
- `edit.blade.php`

**Parameters:**
```php
@include('admin.products.partials._price_fields', [
    'product' => $product,  // null for create, $product for edit
    'readonly' => false     // Optional: true for view-only
])
```

## How to Make Changes

### To Update Field Labels or Validation
1. Edit the partial file directly
2. Changes automatically apply to all pages using that partial
3. No need to update create, edit, and show separately

### Example: Change "Regular Price" to "Base Price"
```php
// Edit: resources/views/admin/products/partials/_price_fields.blade.php
<label for="price" class="form-label">Base Price <span class="text-danger">*</span></label>
```

✅ This change will automatically appear in:
- Create page
- Edit page
- Any future pages using this component

## Benefits

1. **Consistency** - All pages use the same field structure
2. **Maintainability** - Update once, applies everywhere
3. **Efficiency** - No duplicate code
4. **Reliability** - Reduces human error
5. **Scalability** - Easy to add new pages

## Field Mapping (Dashboard to Database)

| Form Field | Database Column | Description |
|------------|----------------|-------------|
| Regular Price | `regular_price` | Original/full price |
| Sale Price | `sale_price` | Discounted price (optional) |
| Stock | `quantity` | Number of items available |
| Product Name | `name` | Product title |
| Slug | `slug` | URL-friendly name |
| Category | `category_id` | Foreign key to categories |
| Brand | `brand_id` | Foreign key to brands |
| Description | `description` | Product details |

## Frontend Display Logic

```php
IF sale_price EXISTS AND sale_price < regular_price:
    Show: $sale_price (highlighted)
    Show: $regular_price (crossed out)
    Show: discount percentage badge
ELSE:
    Show: $regular_price only
```
