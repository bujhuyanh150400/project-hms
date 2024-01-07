<?php

namespace App\Http\Requests\Admin\Usercontroller;

use App\Helper\PermissionAdmin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'filter.keyword' => 'sometimes|string|max:255',
            'filter.role' => [
                'sometimes',
                Rule::in(array_keys(PermissionAdmin::getList())),
            ],
            'filter.start_date_create' => 'sometimes|date_format:d-m-Y',
            'filter.end_date_create' => 'sometimes|date_format:d-m-Y',
        ];
    }
}
