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
     *      title="Fund amount",
     *      description="Fund amount ",
     *      example="10000"
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
            'amount' => 'required|numeric|gt:1000',
        ];
    }
}
