<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Payment Method Create Form Request Fields",
 *      description="Payment Method Create request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class PaymentMethodCreateFormRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="name of payment method",
     *      example="Card"
     * )
     *
     * @var string
     */
    private $name;


    /**
     * @OA\Property(
     *      title="type",
     *      description="type of payment method",
     *      example="Card"
     * )
     *
     * @var string
     */
    private $type;


    /**
     * @OA\Property(
     *      title="connect",
     *      description="connect of payment method",
     *      example="Card"
     * )
     *
     * @var string
     */
    private $connect;

    /**
     * @OA\Property(
     *      title="payment_gateway",
     *      description="payment_gateway of payment method",
     *      example="paystack"
     * )
     *
     * @var string
     */
    private $payment_gateway;

    /**
     * @OA\Property(
     *      title="stage",
     *      description="stage of payment method",
     *      example="live"
     * )
     *
     * @var string
     */
    private $stage;

    /**
     * @OA\Property(
     *      title="public_key",
     *      description="public_key of payment method",
     *      example="live"
     * )
     *
     * @var string
     */
    private $public_key;


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
            'name' => 'required|string',
            'type' => 'required|string',
            'connect' => 'required|string',
            'payment_gateway' => 'required|string',
            'stage' => 'required|string|in:test,live',
            'public_key' => 'required|string',
        ];
    }
}
