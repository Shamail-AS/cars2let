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
        return \Auth::user()->isAdmin;
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
            'name' => 'required|regex:/^[a-zA-Z ]*$/',
            'passport_num' => 'alpha_num|unique:investors',
            'email' => 'required|email|unique:investors',
            'phone'=> 'numeric',
            'dob' => 'date'
        ];
    }
}
