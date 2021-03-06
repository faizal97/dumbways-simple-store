<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'productId' => [
                'required',
                Rule::exists(Product::class, 'id'),
            ],
            'amount' => [
                'required',
                'integer',
                'min:1',
            ],
            'totalPaid' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
    }
}
