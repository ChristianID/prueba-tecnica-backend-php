<?php

namespace App\Http\Requests;

use App\Rules\ValidateStatus;
use App\Rules\ValidateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ScheduleUpdate extends FormRequest
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
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        $data = $this->all();

        if (count($data) == 0) {
            abort(400, 'Bad request. No data found');
        }

        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'hour'   => ['nullable', new ValidateTime, 'unique:schedules,hour,'.$this->route('id')],
            'status' => ['nullable', new ValidateStatus]
        ];
    }
}
