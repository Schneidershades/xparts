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
     *      title="Xpart Part ID",
     *      description="Xpart Part ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $part_id;

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
            'part_id' => 'required|int|exists:parts,id',
            'vin_id' => 'int|exists:vins,id',     
        ];
    }
}
