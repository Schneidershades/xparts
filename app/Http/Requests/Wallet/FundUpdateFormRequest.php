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
        ];
    }
}
