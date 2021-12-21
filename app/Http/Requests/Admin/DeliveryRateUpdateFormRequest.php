<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Delivery Rates Update Form Request Fields",
 *      description="MDelivery Rates Update request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class DeliveryRateUpdateFormRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="type",
     *      description="Type of deliveryRates",
     *      example="flat"
     * )
     *
     * @var string
     */
    private $type;

    /**
     * @OA\Property(
     *      title="destinatable_id",
     *      description="destinatable_id of deliveryRates",
     *      example="flat"
     * )
     *
     * @var int
     */
    private $destinatable_id;

    /**
     * @OA\Property(
     *      title="destinatable_type",
     *      description="destinatable_type of deliveryRates",
     *      example="flat"
     * )
     *
     * @var string
     */
    private $destinatable_type;

    /**
     * @OA\Property(
     *      title="Min Value",
     *      description="Minimum Value of the Price",
     *      example="100000.00"
     * )
     *
     * @var string
     */
    private $amount;

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
            'type' => 'required',
            'destinatable_id' => 'nullable|int',
            'destinatable_tyoe' => 'nullable|string|max:255|in:states,cites,countries',
            'amount' => 'required|numeric|min:1',
        ];
    }
}
