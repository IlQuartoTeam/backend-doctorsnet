<?php

namespace App\Http\Requests;

use Faker\Guesser\Name;
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
            'name' => 'required',
            'surname' => 'required',
            'phone' => 'nullable',
            'profile_image_url' => 'url',
            'address' => 'required',
            'city' => 'required',
            'examinations' => 'nullable',
            'specializations' => 'required|exists:specializations,id',


        ];
    }

    public function messages() {
        return [
            'name.required' => 'Inserisci un nome',
            'surname.required' => 'Inserisci un cognome',
            'city.required' => 'La città è obbligatoria',
            'address.required' => "L'indirizzo è obbligatorio",
            "profile_image_url" => "Link non valido",
            'specializations.exists' => 'Specializzazione non presente',



        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_BAD_REQUEST)
        );
    }
}
