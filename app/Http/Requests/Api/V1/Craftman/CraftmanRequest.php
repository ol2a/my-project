<?php

namespace App\Http\Requests\Api\V1\Craftman;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;

class CraftmanRequest extends FormRequest
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
            'name' => 'required',
            'email' =>[
                'required',
                'email',
                Rule::unique('craftmen')->where(fn (Builder $builder) => $builder->where('email' , $this->email)),
            ],
            'address' => 'required',
            'national_id' => 'required|min:14|max:14'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()

        ]));
    }
}
