<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveProjectsRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        // Se pueden poner distintas reglas con condicionales dependiendo del metodo
        // if ($this->isMethod('PATCH')){
        //     return [
        //         //
        //     ];
        // }
        return [
            'title' => ['required'],
            'link' => ['required'],
            'image_path' => []
        ];
    }
}