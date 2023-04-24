<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreateTicketRequest extends FormRequest
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
            'title' => 'required',
            'type' => 'required',
            'priority' => 'required',
            'description' => 'required',
            'context' => 'required',
            'browser' => 'required',
            'os' => 'required',
            'project_id' => 'required',
        ];
    }

    public function failedValidation(Validator $validator) {
      throw new HttpResponseException(response() -> json([
        'success' => false,
        'error' => true,
        'message' => 'Erreur de validation',
        'errorsList' =>  $validator->errors()
      ]));
    } 

    public function messages(){
      return [
        'title.required' => 'Le titre est requis',
        'type.required' => 'Le type est requis',
        'priority.required' => 'La priorité est requise',
        'description.required' => 'La description est requise',
        'context.required' => 'Le contexte est requis',
        'browser.required' => 'Le navigateur est requis',
        'os.required' => 'Le système d\'exploitation est requis'
      ];
    }
}
