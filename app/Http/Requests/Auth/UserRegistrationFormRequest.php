<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
/**
 * @OA\Schema(
 *      title="Sign Up Form Request Fields",
 *      description="sign up request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class UserRegistrationFormRequest extends FormRequest
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
     *      example="info@convertscript.com"
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
     *      title="User username",
     *      description="username of the user",
     *      example="info@xpart.com"
     * )
     *
     * @var string
     */
    public $username;

    /**
     * @OA\Property(
     *      title="User password",
     *      description="Password of the user",
     *      example="password"
     * )
     *
     * @var string
     */
    public $password;

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
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'phone' => 'required|int|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|max:255|in:User,Vendoe',
        ];
    }
}