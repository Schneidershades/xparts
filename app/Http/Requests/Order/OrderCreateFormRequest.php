<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Order Create Form Request Fields",
 *      description="Order Create Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */


class OrderCreateFormRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="User Address id",
     *      description="Address ID of the user",
     *      example="1"
     * )
     *
     * @var int
     */
    public $address_id;

    /**
     * @OA\Property(
     *      title="Order Type",
     *      description="Order Type",
     *      example="quote"
     * )
     *
     * @var string
     */
    public $orderable_type;

    /**
     * @OA\Property(
     *      title="Orderable id",
     *      description="Orderable type",
     *      example="1"
     * )
     *
     * @var int
     */
    public $orderable_id;
    
    /**
    *       @OA\Property(property="quotes", type="object", type="array",
    *            @OA\Items(
    *                @OA\Property(property="itemable_id", type="int", example="1"),
    *                @OA\Property(property="quantity", type="int", example="1"),
    *                @OA\Property(property="itemable_type", type="string", example="quote"),
    *            ),
    *        ),
    *    ),
    */

    public $quotes;

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
            'address_id' => 'required|int|exists:addresses,id',
            'orderable_type' => 'required|string',
            'orderable_id' => 'required|id',
        ];
    }
}
