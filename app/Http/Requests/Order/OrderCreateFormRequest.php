<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Order Create Form Request Fields",
 *      description="Order Create Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */


class OrderCreateFormRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="User Address id",
     *      description="Address ID of the user",
     *      example="1"
     * )
     *
     * @var int
     */
    public $address_id;
    
    /**
    *       @OA\Property(property="cart", type="object", type="array",
    *            @OA\Items(
    *                @OA\Property(property="itemable_id", type="int", example="1"),
    *                @OA\Property(property="itemable_type", type="string", example="quotes"),
    *                @OA\Property(property="quantity", type="int", example="1"),
    *            ),
    *        ),
    *    ),
    */

    public $cart;


    /**
     * @OA\Property(
     *      title="Orderable id",
     *      description="Address ID of this transaction",
     *      example="1"
     * )
     *
     * @var int
     */
    public $orderable_id;


    /**
     * @OA\Property(
     *      title="Orderable type",
     *      description="Orderable type of this transaction",
     *      example="1"
     * )
     *
     * @var int
     */
    public $orderable_type;

    /**
     * @OA\Property(
     *      title="Payment Method id",
     *      description="Payment Method ID of this transaction",
     *      example="1"
     * )
     *
     * @var int
     */
    public $payment_method_id;
    

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
            'address_id' => 'required|int|exists:addresses,id',
            'cart' => 'required|array', 
            'cart.*.quantity' => 'required|int',
            'cart.*.itemable_id' => 'required|int',
            'cart.*.itemable_type' => 'required|string',
            'payment_method_id' => 'required|int',
        ];
    }
}
