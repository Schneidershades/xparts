<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Multiple Xpart Request Create Form Request Fields",
 *      description="Multiple Xpart Request Create Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */

class StoreMultipleXpartRequest extends FormRequest
{
    /**
    *       @OA\Property(property="xpart_requests", type="object", type="array",
    *            @OA\Items(
    *                @OA\Property(
    *                   property="part", 
    *                   type="string", 
    *                   example="seatbelt holder"
    *               ),
    *                @OA\Property(
    *                   property="vin_number", 
    *                   type="string", 
    *                   example="Vin Number ID"
    *               ),
    *                @OA\Property(
    *                   property="user_description", 
    *                   type="string", 
    *                   example="This is a description"
    *               ),
    *                @OA\Property(
    *                   property="images", 
    *                   type="string", 
    *                   type="[1,2,3]",
    *               ),
    *            ),
    *        ),
    *    ),
    */

    public $xpart_requests;

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
            'xpart_requests' => 'array',
            'xpart_requests.*.part' => 'required|string',
            'xpart_requests.*.vin_number' => 'required|string',
            'xpart_requests.images' => 'nullable|array',
            'xpart_requests.images.*' => 'nullable|max:2048',  
            'xpart_requests.*.user_description' => 'nullable',  
            'xpart_requests.*.admin_description' => 'nullable',  
        ];
    }
}
