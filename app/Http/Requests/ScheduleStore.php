<?php

namespace App\Http\Requests;

use App\Rules\ValidateTime;
use App\Rules\ValidateStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ScheduleStore extends FormRequest
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
            'hour'   => ['required',new ValidateTime,'unique:schedules'],
            'status' => ['required', new ValidateStatus]
        ];
    }
}
