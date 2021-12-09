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
     * @var string
     */
    public $part;

    /**
     * @OA\Property(
     *      title="Vin Number",
     *      description="Vin Number ID",
     *      example="48938484803390"
     * )
     *
     * @var string
     */
    public $vin_number;

    /**
     * @OA\Property(
     *      title="user_description",
     *      description="user_description",
     *      example="this is a description"
     * )
     *
     * @var string
     */
    public $user_description;
    

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
            'user_description' => 'nullable',  
            'admin_description' => 'nullable',      
        ];
    }
}
