<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterCarRequest extends Request
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
            'reg_no' => 'required|unique:cars',
            'make' => 'alpha',
        ];
    }
}