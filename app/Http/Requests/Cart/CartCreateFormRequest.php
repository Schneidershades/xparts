<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Cart Create Form Request Fields",
 *      description="Cart Create Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */

class CartCreateFormRequest extends FormRequest
{

    /**
     * @OA\Property(
     *      title="Model ID",
     *      description="Model ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $cartable_id;

    /**
     * @OA\Property(
     *      title="Model Type",
     *      description="Model Type",
     *      example="quote"
     * )
     *
     * @var string
     */
    public $cartable_type;

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
            'cartable_type' => 'required|string',
            'cartable_id' => 'integer',
        ];
    }
}
