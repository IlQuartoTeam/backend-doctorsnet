<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'

        ];
    }

    public function messages() {
        return [
            'name.required' => 'Inserisci un nome',
            'name.max' => 'Il nome è troppo lungo',
            'surname.required' => 'Inserisci un cognome',
            'surname.max' => 'Hai inserito un cognome troppo lungo',
            'email.required' => "L'email è richiesta",
            'email.unique' => "Email già presente nei nostri sistemi",
            'email.email' => "Inserisci una mail valida",
            'password.required' => "La password è richiesta",
            'password.min' => "La password deve essere di :min caratteri"

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_BAD_REQUEST)
        );
    }
}
