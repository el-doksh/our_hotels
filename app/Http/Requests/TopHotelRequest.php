<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopHotelRequest extends FormRequest
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
            'from' => 'sometimes|date',
            'to' => 'sometimes|date',
            'city' => 'sometimes',
            'adultsCount' => 'sometimes|integer',
        ];
    }
}
