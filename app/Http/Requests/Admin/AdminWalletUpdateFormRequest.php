<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Admin Wallet Update Form Request Fields",
 *      description="Admin Wallet Update request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class AdminWalletUpdateFormRequest extends FormRequest
{
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
     * @OA\Property(
     *      title="remarks",
     *      description="remarks",
     *      example="this is a description"
     * )
     *
     * @var string
     */
    private $remarks;

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
            'remarks' => 'string',
            'status' => 'required|string|in:approved,declined',
        ];
    }
}
