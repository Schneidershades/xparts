<?php

namespace App\Http\Requests\Wallet;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *      title="Withdrawal Create Form Request Fields",
 *      description="Withdrawal Create Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */


class WithdrawalCreateFormRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="Withdrawal amount",
     *      description="Withdrawal amount ",
     *      example="1000"
     * )
     *
     * @var int
     */
    public $amount;

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
            'amount' => 'required|numeric|min:1000',
        ];
    }
}
