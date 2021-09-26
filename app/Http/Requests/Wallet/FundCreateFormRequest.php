<?php

namespace App\Http\Requests\Wallet;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Fund Create Form Request Fields",
 *      description="Fund Create Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */

class FundCreateFormRequest extends FormRequest
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
     *      title="Fund amount",
     *      description="Fund amount ",
     *      example="10000"
     * )
     *
     * @var int
     */
    public $amount;

    /**
     * @OA\Property(
     *      title="Orderable id",
     *      description="Orderable id",
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
     *      example="wallets"
     * )
     *
     * @var int
     */
    public $orderable_type;

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
            'payment_method_id' => 'int',
            'amount' => 'required|int',
            'orderable_id' => 'int',
            'orderable_type' => 'required|string|max:255|in:wallets',
        ];
    }
}
