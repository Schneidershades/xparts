<?php

namespace App\Http\Requests\Wallet;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Fund Update Form Request Fields",
 *      description="Fund Update Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */

class FundUpdateFormRequest extends FormRequest
{

    /**
     * @OA\Property(
     *      title="payment method id",
     *      description="payment method",
     *      example="1"
     * )
     *
     * @var int
     */
    public $payment_method_id;

    /**
     * @OA\Property(
     *      title="Orderable id",
     *      description="Orderable Id",
     *      example="1"
     * )
     *
     * @var int
     */
    public $orderable_id;

    /**
     * @OA\Property(
     *      title="Orderable type",
     *      description="Orderable type",
     *      example="walletTransactions"
     * )
     *
     * @var int
     */
    public $orderable_type;


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
            'payment_reference' => 'required|string',
            'payment_gateway' => 'required|string',
            'orderable_id' => 'required|int',
            'orderable_type' => 'required|string|in:walletTransactions',
            'payment_method_id' => 'int',
        ];
    }
}
