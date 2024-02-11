<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Category\Category;
use App\Models\Tag\Tag;
use Illuminate\Foundation\Http\FormRequest;

class ProductSaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => [
                'nullable',
                'string',
            ],
            'show'         => [
                'nullable',
                'boolean',
            ],
            'categories'   => [
                'nullable',
                'array',
            ],
            'categories.*' => [
                'required',
                'integer',
                'exists:' . (new Category())->getTable() . ',id',
            ],
            'tags'         => [
                'nullable',
                'array',
            ],
            'tags.*'       => [
                'required',
                'integer',
                'exists:' . (new Tag())->getTable() . ',id',
            ],
            'company.id'   => [
                'nullable',
            ],
            'company.name' => [
                'nullable',
                'string',
            ],
        ];
    }
}
