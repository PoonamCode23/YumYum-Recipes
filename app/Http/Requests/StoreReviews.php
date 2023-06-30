<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviews extends FormRequest
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
        return [
            'review' => 'required|string',
            'recipe_id' => 'required|numeric',
            'rating' => 'required|numeric',
        ];
    }

    public function data()
    {
        return [
            'comments'        => $this->input('review'),
            'recipe_id'     => $this->input('recipe_id'),
            'ratings'        => $this->input('rating'),

        ];
    }
}
