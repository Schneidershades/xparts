<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
/**
 * @OA\Schema(
 *      title="Update Admin Form Request Fields",
 *      description="Update Admin request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class UpdateAdminOperatorRequest extends FormRequest
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
     *      description="Email of the user",
     *      example="user@xparts.com"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="User phone",
     *      description="phone of the user",
     *      example="234"
     * )
     *
     * @var string
     */
    public $phone;

    /**
     * @OA\Property(
     *      title="User Role",
     *      description="User/Vendor",
     *      example="User"
     * )
     *
     * @var string
     */
    public $role;

    
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'role' => 'required|string|max:255',
        ];
    }
}
