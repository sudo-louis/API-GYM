<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProveedorRequest extends FormRequest
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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:2048',
            'nombre_empresa' => 'required|string|max:100',
            'nombre_contacto' => 'required|string|max:50',
            'telefono' => 'required|string|max:15',
            'correo' => 'required|string|max:100',
            'productos_suministrados' => 'required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
        'success'=> false,
        'message'=> 'Error de validación',
        'errors'=> $validator->errors()
        ], 422));
    }
}
