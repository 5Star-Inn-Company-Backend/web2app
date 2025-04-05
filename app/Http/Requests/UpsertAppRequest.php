<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpsertAppRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique("apps", 'name')->ignore($this->app)],
            'url' => ['required', 'url', Rule::unique("apps", 'url')->ignore($this->app)],
            'plan' => ['nullable', 'sometimes', 'string'],
            'description' => ['nullable', 'sometimes', 'string'],
            'branding' => ['required'],
            'link_handling' => ['nullable'],
            'interface' => ['required'],
            'website_overide' => ['required'],
            'permission' => ['required'],
            'navigation' => ['required'],
            'notification' => ['required'],
            'plugin' => ['required', 'array'],
            'build_setting' => ['required'],
        ];
    }


    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => "Something is wrong. ".implode(",",$validator->errors()->all()),
            'errors' => $validator->errors(),
        ], 422));
    }
}
