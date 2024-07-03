<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class PostFormRequest extends FormRequest
{
    /**
     * This method is used to modify the input data before it is validated.
     * 
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'title' => ucwords($this->input('title')),
            'slug' => strtolower(Str::slug($this->input('slug'))),
            'content' => ucfirst($this->input('content'))
        ]);
    }

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
            'title' => 'required|string|max:100',
            'slug' => 'required|string|max:255',
            'content' => 'required|string',
        ];
    }
 
    /**
     * Handle a failed validation attempt.
     * Throws an HTTP response exception with JSON formatted validation errors.
     *
     * @return void
     */

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(response()->json([
            'message' => 'error',
            'errors' => $errors
        ], 422));
    }
}
