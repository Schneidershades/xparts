<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *      title="Admin Quote Update Form Request Fields",
 *      description="Admin Quote Update request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class AdminQuoteUpdateFormRequest extends FormRequest
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
     *      title="order_receipt_number",
     *      description="order_receipt_number",
     *      example="43934-493094309-4039430eifje"
     * )
     *
     * @var string
     */
    private $receipt_number;

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
            'receipt_number' => 'required|string|exists:orders,receipt_number',
            'status' => 'required|string|in:vendor2xparts,delivered,expired,refunded',
        ];
    }
}
