<?php

namespace App\Http\Requests;

use App\Models\Drink;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOrderRequest extends FormRequest
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
            'drink_id' => 'required|integer|exists:drinks,id',
            'size' => [
                'required',
                'string',
                Rule::in(['tall', 'grande', 'venti']),
            
                function ($attribute, $value, $fail){
                    $drink = Drink::find($this->drink_id);
                    if ($drink && is_null($drink->getPriceBySize($value))) {
                        $fail("Size {$value} is not available for {$drink->name}");
                    }

                },
            ],
            'quantity' => 'required|integer|min:1',
            'temperature' => 'sometimes|in:hot,cold',
        ];
    }
}
