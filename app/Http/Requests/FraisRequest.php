<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FraisRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Ajustez selon votre logique d'autorisation
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lesFrais.ETP' => 'required|numeric|min:0',
            'lesFrais.KM' => 'required|numeric|min:0',
            'lesFrais.NUI' => 'required|numeric|min:0',
            'lesFrais.REP' => 'required|numeric|min:0',
            'lesLibFrais.*' => 'required|string',
        ];
    }
} 