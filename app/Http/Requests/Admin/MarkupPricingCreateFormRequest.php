<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Markup Pricing Create Form Request Fields",
 *      description="Markup Pricing Create request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class MarkupPricingCreateFormRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="Max Value",
     *      description="Maximum Value of the Price",
     *      example="10000.00"
     * )
     *
     * @var string
     */
    private $min_value;

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
     * @OA\Property(
     *      title="Percentage Value",
     *      description="Percentage Value of the Price",
     *      example="100"
     * )
     *
     * @var string
     */
    private $percentage;

    /**
     * @OA\Property(
     *      title="Markup Type",
     *      description="Type of the Price",
     *      example="quotes"
     * )
     *
     * @var boolean
     */
    private $type;

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
            'min_value' => 'required|numeric|min:1',
            'max_value' => 'required|numeric|min:1',
            'type' => 'required|string',
            'percentage' => 'required|numeric|min:1|max:100',
        ];
    }
}
