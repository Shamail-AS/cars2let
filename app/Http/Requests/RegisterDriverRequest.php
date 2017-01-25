<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterDriverRequest extends Request
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
            'license_no' => 'required|unique:drivers',
            'pco_license_no' => 'required|unique:drivers',
            'email' => 'required|unique:drivers',
        ];
    }
}
