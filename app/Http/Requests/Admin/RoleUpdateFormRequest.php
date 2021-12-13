<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
/**
 * @OA\Schema(
 *      title="Role Update Form Request Fields",
 *      description="Role Update request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class RoleUpdateFormRequest extends FormRequest
{

    /**
     * @OA\Property(
     *      title="Role Name",
     *      description="name of the role",
     *      example="Super Admin"
     * )
     *
     * @var string
     */
    public $name;
    
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
            'name' => 'required|string|max:255',
        ];
    }
}
