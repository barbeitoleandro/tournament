<?php


namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateTournamentMaleRequest extends FormRequest
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
            'players' => 'required|array',
            'players.*.name' => 'required|string|max:50',
            'players.*.gender' => 'required|string|in:Male',
            'players.*.skill_level' => 'required|integer|between:1,100',
            'players.*.strength' => 'required|integer|between:1,100',
            'players.*.speed' => 'required|integer|between:1,100',
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