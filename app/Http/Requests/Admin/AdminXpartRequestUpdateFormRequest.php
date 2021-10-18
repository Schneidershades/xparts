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
     *      title="status",
     *      description="status",
     *      example="approve/decline"
     * )
     *
     * @var string
     */
    private $status;

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
            'status' => 'required|string|in:approved,declined,vendor2xparts,xparts2user,expired',
        ];
    }
}
