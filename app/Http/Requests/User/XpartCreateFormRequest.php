<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Xpart Request Create Form Request Fields",
 *      description="Xpart Request Create Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */

class XpartCreateFormRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="Xpart Part name",
     *      description="Xpart Part name",
     *      example="seatbelt holder"
     * )
     *
     * @var int
     */
    public $name;

    /**
     * @OA\Property(
     *      title="Vin Number",
     *      description="Vin Number ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $vin_id;
    

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
            'part' => 'required|string',
            'vin_number' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|max:2048',     
        ];
    }
}
