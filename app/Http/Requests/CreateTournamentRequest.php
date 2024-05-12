<?php


namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateTournamentRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'date' => 'required|date|date_format:Y-m-d',
            'gender' => 'required|string|in:Female,Male',            
        ];
    }

    public function response(array $errors)
    {
        // Always return JSON.
        return response()->json($errors, 422);
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'erros' => $validator->errors()
        ], 422));
    }
}