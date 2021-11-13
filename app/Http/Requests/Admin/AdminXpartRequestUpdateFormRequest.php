<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Admin XpartRequest Update Form Request Fields",
 *      description="Admin XpartRequest Update request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class AdminXpartRequestUpdateFormRequest extends FormRequest
{
      /**
     * @OA\Property(
     *      title="admin_description",
     *      description="admin_description",
     *      example="This is the item i need"
     * )
     *
     * @var string
     */
    private $admin_description;

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
            'admin_description' => 'required|string',
        ];
    }
}
