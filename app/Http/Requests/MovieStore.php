<?php

namespace App\Http\Requests;

use App\Rules\ValidateStatus;
use App\Rules\ValidOnBillboardField;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class MovieStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => 'required|string',
            'thumbnail'     => 'required|file|mimes:jpeg,jpg,png',
            'release_date'  => 'required|date',
            'on_billboard'  => ['required', new ValidateStatus]
        ];
    }
}
