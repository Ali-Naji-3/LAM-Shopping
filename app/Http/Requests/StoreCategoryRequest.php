<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'nullable|string|max:255|unique:categories,slug|regex:/^[a-z0-9-]+$/',
            'description' => 'nullable|string|max:1000',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
            'order' => 'integer|min:0|max:9999'
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
        ]);

        // Set default order if not provided
        if (!$this->has('order') || $this->order === null) {
            $maxOrder = \App\Models\Category::where('parent_id', $this->parent_id)->max('order');
            $this->merge([
                'order' => ($maxOrder ?? 0) + 1,
            ]);
        }
    }
}