<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

use Illuminate\Foundation\Http\FormRequest;
class StoreMessageRequest extends FormRequest
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
            'text' => 'required|max:3000',
            'email' => 'required|email|max:255',
            'fullname' => 'required|max:100',
            'prefered_date' => 'required|date'


        ];
    }

    public function messages() {
        return [
            'text.required' => 'Un messaggio di prenotazione è richiesto',
            'text.max' => 'Il messaggio può essere di massimo :max caratteri',
            'fullname.required' => 'Devi inserire il tuo nome',
            'fullname.max' => 'Nome troppo lungo',
            'prefered_date.date' => 'Data con formato non valido',
            'prefered_date.required' => "Una data di prenotazione è richiesta",
            'email.required' => "Una mail per essere ricontattati è richiesta",
            "email.email" => "Email con formato non valido"

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_UNAUTHORIZED)
        );
    }
}

