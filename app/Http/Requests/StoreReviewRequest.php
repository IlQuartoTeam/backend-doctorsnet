<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
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
            'email' => 'nullable|email',
            'name' => 'nullable|string',
            'rating' => 'digits_between:1,5|required',
            'text' => 'nullable|max:3000'


        ];
    }

    public function messages() {
        return [
            'email.email' => 'Il formato della mail non è valido',
            'name.string' => 'Non sono accettati solo numeri nel nome',
            'rating.digits_between' => 'Il voto può essere compreso solo tra :min e :max',
            'rating.required' => 'Almeno il voto è obbligatorio',
            'text' => 'La recensione è troppo lunga, massimo :max caratteri',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_UNAUTHORIZED)
        );
    }
}

