<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Carts\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'purchasable_id' => [
                'required',
                'int'
            ],
            'purchasable_type' => [
                'required',
                'string',
                'in:variant,bundle'
            ]
        ];
    }
}
