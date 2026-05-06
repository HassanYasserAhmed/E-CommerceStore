<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (request()->route('category')) {
            return Gate::allows('categories.update');
        }

        return Gate::allows('categories.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules($id = 0): array
    {
        $id = $this->route('category');

        return [
            'name' => [
                'required', 'min:3', 'max:255', 'unique:categories,name,'.$id, 'filter',
            ],
            'parent_id' => [
                'int', 'exists:categories,id',
            ],
            'image' => [
                'image', 'dimensions:min_length:100,min_height:100',
            ],
            'status' => 'in:active,archived',

        ];
    }
    //    public function messages() {
    //     return [
    //         'name.required'=>'Category Name is required',
    //     ];
    //    }
}
