<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;


/**
/**
 * @OA\Schema(
 *      title="Vehicle Specialization Update Form Request Fields",
 *      description="Vehicle Specialization Update request body data",
 *      type="object",
 *      required={"name"}
 * )
 */


 
class VehicleSpecializationUpdateFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
