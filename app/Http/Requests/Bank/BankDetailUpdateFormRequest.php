<?php

namespace App\Http\Requests\Bank;

use Illuminate\Foundation\Http\FormRequest;

class BankDetailUpdateFormRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="Bank Account Name",
     *      description="Bank Account Name",
     *      example="quote"
     * )
     *
     * @var string
     */
    public $bank_account_name;

    /**
     * @OA\Property(
     *      title="Bank Account Number",
     *      description="Bank Account Number",
     *      example="quote"
     * )
     *
     * @var string
     */
    public $bank_account_number;

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
            'bank_account_name' => 'required|string',
            'bank_account_number' => 'required|string',
        ];
    }
}
