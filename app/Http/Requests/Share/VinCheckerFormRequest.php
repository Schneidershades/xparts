<?php

namespace App\Http\Requests\Share;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="VIN Checker Form Request Fields",
 *      description="VIN Checker Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */

class VinCheckerFormRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="VIN Number",
     *      description="VIN number",
     *      example="5TDZA22C14S086770"
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
            'vin_number' => 'required|string',
        ];
    }
}
