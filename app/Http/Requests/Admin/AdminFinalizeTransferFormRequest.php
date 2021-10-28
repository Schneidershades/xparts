<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *      title="Withdrawal Finalize Form Request Fields",
 *      description="Withdrawal Finalize Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */

class AdminFinalizeTransferFormRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="Order receipt payment reference",
     *      description="Order  receipt payment reference",
     *      example="quote"
     * )
     *
     * @var string
     */
    public $receipt_number;


    /**
     * @OA\Property(
     *      title="Order payment paystack otp",
     *      description="Order payment paystack otp",
     *      example="593349"
     * )
     *
     * @var int
     */
    public $otp;

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
            'otp' => 'required|int',
            'receipt_number' => 'required|string',
        ];
    }
}
