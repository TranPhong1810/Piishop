<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'          => 'required',
            'description'   => 'required',
            'sale'          => 'required|integer|min:0|max:100',
            'price'         => 'required|numeric|min:1000',
            'image'         => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'Tên sản phẩm là bắt buộc',
            'description.required'  => 'Mô tả là bắt buộc',
            'sale.required'         => 'Giảm giá là bắt buộc',
            'sale.integer'          => 'Giảm giá phải là số nguyên',
            'sale.min'              => 'Giảm giá không được nhỏ hơn 0%',
            'sale.max'              => 'Giảm giá không được lớn hơn 100%',
            'price.required'        => 'Giá là bắt buộc',
            'price.numeric'         => 'Giá phải là số',
            'price.min'             => 'Giá phải lớn hơn hoặc bằng 1000',
            'image.required'        => 'Hình ảnh là bắt buộc',
        ];
    }
}
