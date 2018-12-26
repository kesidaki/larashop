<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'name'        => 'required',
            'address'     => 'required',
            'tk'          => 'required',
            'city'        => 'required',
            'state'       => 'required',
            'phone'       => 'required',
            'email'       => 'required',
            'shipping_id' => 'required',
            'payment'     => 'required',
            'type'        => 'required',
            'doy'         => 'required_if:type,==,Τιμολόγιο',
            'afm'         => 'required_if:type,==,Τιμολόγιο',
            'profession'  => 'required_if:type,==,Τιμολόγιο',
        ];
    }
}
