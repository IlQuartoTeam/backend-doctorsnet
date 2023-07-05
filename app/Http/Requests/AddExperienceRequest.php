<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

use Illuminate\Foundation\Http\FormRequest;

class AddExperienceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'type' => 'required',
            'start_date' => 'date|required',
            'end_date' => 'nullable|date'

        ];
    }

    public function messages() {
        return [
            'name.required' => 'Il nome è richiesto',
            'type.required' => 'Il tipo è richiesto',
            'start_date.date' => 'Data con formato non corretto',
            'start_date.required' => 'Data di inizio richiesta',
            'end_date.date' => 'Data con formato non corretto',




        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_UNAUTHORIZED)
        );
    }
}
