<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
/**
 * @OA\Schema(
 *      title="User Update Form Request Fields",
 *      description="User Update request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class UserUpdateFormRequest extends FormRequest
{
     /**
     * @OA\Property(
     *      title="User Name",
     *      description="name of the user",
     *      example="Schneider"
     * )
     *
     * @var string
     */
    public $name;


     /**
     * @OA\Property(
     *      title="User email",
     *      description="email of the user",
     *      example="Schneider@fixit45.com"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="User phone",
     *      description="phone of the user",
     *      example="07037495705"
     * )
     *
     * @var string
     */
    public $phone;

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
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
        ];
    }
}
