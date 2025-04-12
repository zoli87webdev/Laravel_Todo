<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * A kérés engedélyezett-e a felhasználó számára?
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Az alkalmazásban ezt beállíthatod a szükséges jogosultságokhoz
    }

    /**
     * A kérés érvényesítési szabályainak meghatározása.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'is_completed' => 'nullable|boolean',
        ];

        if ($this->isMethod('post') || $this->has('title')) {
            $rules['title'] = [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-zÀ-ÿ\s]+$/u',
            ];
        }

        return $rules;
    }
}
