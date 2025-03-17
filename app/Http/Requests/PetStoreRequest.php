<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PetStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "pet_name" => "required",
            "pet_breed" => "required",
            "pet_tag" => "required"
        ];
    }

    public function messages()
    {
        return [
            'pet_name.required'  => 'Pole imie jest wymagane',
            'pet_breed.required' => 'Pole rasa jest wymagane',
            'pet_tag.required' => 'Pole tag jest wymagane',
        ];
    }
}
