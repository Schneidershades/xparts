<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Address Create Form Request Fields",
 *      description="Address Create Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */

class AddressCreateFormRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="User First Name",
     *      description="First name of the user",
     *      example="Nnamdi"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="User Address",
     *      description="Address of the user",
     *      example="No 4 Gang street"
     * )
     *
     * @var string
     */
    public $address;

    /**
     * @OA\Property(
     *      title="User state",
     *      description="state of the user",
     *      example="No 4 Gang street"
     * )
     *
     * @var string
     */
    public $state;

    /**
     * @OA\Property(
     *      title="User postal_code",
     *      description="postal_code of the user",
     *      example="900233"
     * )
     *
     * @var string
     */
    public $postal_code;

    /**
     * @OA\Property(
     *      title="User primary address",
     *      description="primary address of the user",
     *      example="false"
     * )
     *
     * @var boolean
     */
    public $primary_address;
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
            'name' => 'string|max:255',
            'address' => 'required|string',
            'state' => 'required|string',
            'postal_code' => 'integer',
            'primary_address' => 'boolean',
        ];
    }
}
