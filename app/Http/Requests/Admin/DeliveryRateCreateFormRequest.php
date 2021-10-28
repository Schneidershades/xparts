<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Delivery Rates Create Form Request Fields",
 *      description="Delivery Rates Create request body data",
 *      type="object",
 *      required={"name"}
 * )
 */


class DeliveryRateCreateFormRequest extends FormRequest
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
     *      title="Min Value",
     *      description="Minimum Value of the Price",
     *      example="100000.00"
     * )
     *
     * @var string
     */
    private $max_value;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}