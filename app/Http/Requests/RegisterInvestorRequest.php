<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterInvestorRequest extends Request
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
            //
            'name' => 'required|alpha',
            'passport_num' => 'required|alpha_num|unique:investors',
            'email' => 'required|email|unique:investors',
            'phone'=> 'numeric',
            'dob' => 'date'
        ];
    }
}
