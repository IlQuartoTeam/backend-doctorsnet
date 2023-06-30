<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
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
            'phone' => 'digits_between:9,11|nullable',
            'profile_image_url' => 'url',
            'address' => 'required',
            'city' => 'required',
            'examinations' => 'nullable',


        ];
    }

    public function messages() {
        return [
            'city.required' => 'La città è obbligatoria',
            'address.required' => "L'indirizzo è obbligatorio",
            'phone.digits_between' => "Il numero di telefono non ha un formato corretto",
            "profile_image_url" => "Link non valido"


        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_BAD_REQUEST)
        );
    }
}
