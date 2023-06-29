<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

use Illuminate\Foundation\Http\FormRequest;


class LoginUserRequest extends FormRequest
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
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8'

        ];
    }

    public function messages() {
        return [
            'email.required' => 'La mail è richiesta per il login',
            'email.email' => 'Inserisci una mail valida',
            'email.required' => "L'email è richiesta",
            'email.unique' => "Email già presente nei nostri sistemi",
            'password.required' => "La password è richiesta",
            'password.min' => "La password deve essere di :min caratteri"

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_UNAUTHORIZED)
        );
    }
}
