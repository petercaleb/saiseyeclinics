<?php

namespace App\Http\Requests\Admin\Settings\Cases;

use Illuminate\Foundation\Http\FormRequest;

class FrameCaseRequest extends FormRequest
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
            //
            'color_id' => ['required', 'exists:case_colors,id', 'integer'],
            'size_id' => ['required', 'integer', 'exists:case_sizes,id'],
            'shape_id' => ['required', 'integer', 'exists:case_shapes,id']
        ];
    }
}
