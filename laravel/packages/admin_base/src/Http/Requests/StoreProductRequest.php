<?php

namespace Marol\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|max:32',
            'describe' => 'required|max:128',
            'category_id' => 'required|exists:product_categories,id',
            'describe' => 'nullable|max:100',
            'price' => 'array|min:1',
            'price.*.price' => 'present_with:price|decimal:2',
            'price.*.price' => 'present_with:price|decimal:2',
            'price.*.scope' => 'nullable|in:normal,discount,vip',
            'price.*.describe' => 'nullable|max:100',
        ];
    }
}
