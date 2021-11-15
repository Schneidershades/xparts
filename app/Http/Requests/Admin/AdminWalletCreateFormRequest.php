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
     *      example="user_id"
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
     *      title="status",
     *      description="status",
     *      example="approve/decline"
     * )
     *
     * @var string
     */
    private $status;

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
            'user_id' => 'required|string|in:approve,decline',
            'amount' => 'required|numeric|gt:100',
            'payment_method' => 'required|numeric|in:bank-transfer',
            'details' => 'required|string',
            'transaction_type' => 'required|string|in:debit,credit',
        ];
    }
}
