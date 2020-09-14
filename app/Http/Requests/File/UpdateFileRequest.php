<?php

namespace App\Http\Requests\File;

use App\Http\Requests\File\StoreFileRequest;

class UpdateFileRequest extends StoreFileRequest
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
        return array_merge(parent::rules(), [
            'live' => '',
        ]);
    }

    public function messages()
    {
        return parent::messages();
    }
}
