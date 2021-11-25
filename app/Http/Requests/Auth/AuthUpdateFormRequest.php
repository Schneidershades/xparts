<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
/**
 * @OA\Schema(
 *      title="User Update Form Request Fields",
 *      description="User Update request body data",
 *      type="object",
 *      required={"first_name"}
 * )
 */

class AuthUpdateFormRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            // 'name' => 'string|max:255',
            // 'email' => 'string|email|max:255|unique:users,email',
            // 'phone' => 'string|unique:users,phone',
            'image' => 'nullable|max:2048',
            'fcm_token' => 'nullable'
        ];
    }
}
