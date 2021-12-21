<?php

namespace App\Http\Requests\Shared;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="VIN Checker Form Request Fields",
 *      description="VIN Checker Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */

class StorePartVinPriceEstimateRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="part_name",
     *      description="part_name",
     *      example="seatbelt holder"
     * )
     *
     * @var string
     */
    public $part_name;

    /**
     * @OA\Property(
     *      title="vin_number",
     *      description="vin_number",
     *      example="489333398493333XXX"
     * )
     *
     * @var string
     */
    public $vin_number;

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
            'part_name' => 'required|integer',
            'vin_number' => 'nullable|string',
        ];
    }
}
