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
