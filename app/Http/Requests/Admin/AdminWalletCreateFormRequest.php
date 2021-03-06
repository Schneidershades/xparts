<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Admin Wallet Create Form Request Fields",
 *      description="Admin Wallet Create request body data",
 *      type="object",
 *      required={"name"}
 * )
 */
class AdminWalletCreateFormRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="user_id",
     *      description="user_id",
     *      example="1"
     * )
     *
     * @var string
     */
    private $user_id;
    /**
     * @OA\Property(
     *      title="amount",
     *      description="amount",
     *      example="1000"
     * )
     *
     * @var string
     */
    private $amount;

    /**
     * @OA\Property(
     *      title="charge",
     *      description="charge",
     *      example="1"
     * )
     *
     * @var string
     */
    private $charge;

    /**
     * @OA\Property(
     *      title="payment_method_id",
     *      description="payment_method_id",
     *      example="1"
     * )
     *
     * @var string
     */
    private $payment_method_id;

    /**
     * @OA\Property(
     *      title="details",
     *      description="details",
     *      example="This is a transaction"
     * )
     *
     * @var string
     */
    private $details;

    /**
     * @OA\Property(
     *      title="transaction_type",
     *      description="transaction_type",
     *      example="debit/credit"
     * )
     *
     * @var string
     */
    private $transaction_type;

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
            'user_id' => 'required|int|exists:users,id',
            'amount' => 'required|numeric|gt:100',
            'charge' => 'numeric|min:1',
            'payment_method_id' => 'nullable|numeric|exists:payment_methods,id',
            'details' => 'required|string',
            'transaction_type' => 'required|string|in:debit,credit',
        ];
    }
}
