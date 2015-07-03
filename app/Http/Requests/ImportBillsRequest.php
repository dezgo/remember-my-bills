<?php

namespace App\Http\Requests;

class ImportBillsRequest extends Request
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
     * @return array
     * @internal param Request $request
     */
    public function rules()
    {
        //dd($this->files);
        return [
//            'csvfile' => 'required|mimes:test/csv|HasData|CorrectNumColumns|CorrectColumnNames',
            'csvfile' => 'required',
        ];
    }
}
