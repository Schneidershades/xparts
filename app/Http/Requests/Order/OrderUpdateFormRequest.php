<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *      title="Order Update Form Request Fields",
 *      description="Order Update Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */

class OrderUpdateFormRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="Order payment reference",
     *      description="Order payment reference",
     *      example="quote"
     * )
     *
     * @var string
     */
    public $payment_reference;

    /**
     * @OA\Property(
     *      title="Order payment gateway",
     *      description="Order payment gateway",
     *      example="quote"
     * )
     *
     * @var string
     */
    public $payment_gateway;

    /**
     * @OA\Property(
     *      title="Order ID ",
     *      description="Order Id ",
     *      example="quote"
     * )
     *
     * @var int
     */
    public $order_id;


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
            'order_id' => 'required|exists:orders,id',
            // 'payment_reference' => 'required|string|unique:orders,payment_reference',
            'payment_gateway' => 'required|string|max:255|in:paystack,wallet',
        ];
    }
}
