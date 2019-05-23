<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookWorkshopRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'workshop' => 'required|integer',
            'guest_name' => 'array',
            'guest_name.*' => 'string|nullable|required_with:guest_email.*',
            'guest_email' => 'array',
            'guest_email.*' => 'email|nullable|required_with:guest_name.*',
        ];
    }
}
