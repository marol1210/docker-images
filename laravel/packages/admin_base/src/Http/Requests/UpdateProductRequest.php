<?php

namespace Marol\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() || false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|max:32',
            'describe' => 'nullable|max:128',
            'category_id' => 'nullable|exists:product_categories,id',
            'price' => 'nullable|array|min:1',
            'describe' => 'nullable|max:100',
            'price.*' => 'present_with:price|array',
            'price.*.price' => 'nullable|decimal:2',
            'price.*.scope' => 'nullable|in:normal,discount,vip',
            'price.*.describe' => 'nullable|string|max:100',
            'price.*.id' => 'present_with:price|integer',
        ];
    }
}
