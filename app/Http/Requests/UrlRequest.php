<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UrlRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  auth()->check();
//        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'url' => 'required|max:2048',
            'name' => 'required|string|min:3',
            'time_out' => 'required|integer|max:60',
            'max_count_ping' => 'required|integer',
            'status_code' => 'required|integer|min:200|max:500',
            'id_alert' => 'required|integer|exists:alerts,id',
            'id_user' => 'required|integer|exists:users,id',
            'id_project' => 'required|integer|exists:projects,id',
        ];

    }
}
