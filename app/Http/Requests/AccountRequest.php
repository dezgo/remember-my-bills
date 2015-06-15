<?php

namespace App\Http\Requests;

class AccountRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     * Fine as long as the user is logged in
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
            'description' => 'required',
        ];
    }

}
