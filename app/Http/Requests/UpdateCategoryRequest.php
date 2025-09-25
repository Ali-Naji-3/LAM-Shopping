<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->u_type === 'ADM';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $categoryId = $this->route('category')->id;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($categoryId)
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique('categories', 'slug')->ignore($categoryId)
            ],
            'description' => 'nullable|string|max:1000',
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($categoryId) {
                    if ($value == $categoryId) {
                        $fail('A category cannot be its own parent.');
                    }
                    
                    // Check if the selected parent is a descendant
                    if ($value && $this->isDescendant($categoryId, $value)) {
                        $fail('Cannot set a descendant category as parent.');
                    }
                }
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
            'order' => 'integer|min:0|max:9999',
            'remove_image' => 'boolean'
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required.',
            'name.unique' => 'A category with this name already exists.',
            'name.max' => 'Category name cannot exceed 255 characters.',
            'slug.unique' => 'A category with this URL slug already exists.',
            'slug.regex' => 'URL slug can only contain lowercase letters, numbers, and hyphens.',
            'slug.max' => 'URL slug cannot exceed 255 characters.',
            'description.max' => 'Description cannot exceed 1000 characters.',
            'parent_id.exists' => 'The selected parent category does not exist.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'Image must be a JPEG, PNG, JPG, GIF, or WebP file.',
            'image.max' => 'Image size cannot exceed 2MB.',
            'order.integer' => 'Display order must be a number.',
            'order.min' => 'Display order cannot be negative.',
            'order.max' => 'Display order cannot exceed 9999.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'category name',
            'slug' => 'URL slug',
            'description' => 'category description',
            'parent_id' => 'parent category',
            'image' => 'category image',
            'is_active' => 'status',
            'order' => 'display order',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Ensure is_active is boolean
        $this->merge([
            'is_active' => $this->boolean('is_active', true),
            'remove_image' => $this->boolean('remove_image', false),
        ]);
    }

    /**
     * Check if a category is descendant of another
     */
    private function isDescendant($categoryId, $potentialParentId): bool
    {
        $category = \App\Models\Category::find($categoryId);
        if (!$category) {
            return false;
        }

        $descendants = $this->getAllDescendants($category);
        return in_array($potentialParentId, $descendants->pluck('id')->toArray());
    }

    /**
     * Get all descendants of a category
     */
    private function getAllDescendants(\App\Models\Category $category)
    {
        $descendants = collect();
        
        foreach ($category->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($this->getAllDescendants($child));
        }
        
        return $descendants;
    }
}