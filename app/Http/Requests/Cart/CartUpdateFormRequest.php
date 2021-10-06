<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *      title="Cart Update Form Request Fields",
 *      description="Cart Update Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */


class CartUpdateFormRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="Quantity",
     *      description="Quantity",
     *      example="1"
     * )
     *
     * @var int
     */
    public $quantity;

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
            'quantity' => 'required|integer|min:1',
        ];
    }
}
