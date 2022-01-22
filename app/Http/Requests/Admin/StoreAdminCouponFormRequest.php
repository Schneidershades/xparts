<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Admin Store Coupon Form Request Fields",
 *      description="Admin Store Coupon Update request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class StoreAdminCouponFormRequest extends FormRequest
{

    /**
     * @OA\Property(
     *      title="Coupon code",
     *      description="Coupon Code ",
     *      example="Xparts3902"
     * )
     *
     * @var string
     */
    public $code;

    /**
     * @OA\Property(
     *      title="Coupon code",
     *      description="Coupon use percentage instead of amount",
     *      example="10"
     * )
     *
     * @var string
     */
    public $percentage;



    /**
     * @OA\Property(
     *      title="Coupon amount",
     *      description="Coupon use amount instead of percentage",
     *      example="0"
     * )
     *
     * @var string
     */
    public $amount;

    /**
     * @OA\Property(
     *      title="Coupon code",
     *      description="start_date",
     *      example="12/11/2022"
     * )
     *
     * @var string
     */
    public $start_date;

    /**
     * @OA\Property(
     *      title="Coupon code",
     *      description="start_date",
     *      example="12/11/2022"
     * )
     *
     * @var string
     */
    public $expiry_date;

    /**
     * @OA\Property(
     *      title="Coupon usage",
     *      description="Coupon number of users ",
     *      example="5"
     * )
     *
     * @var string
     */
    public $no_of_users;

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
            'code' => 'required|string|max:255',
            'percentage' => 'nullable|numeric|min:0|max:100',
            'amount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date_format:d/m/Y',
            'expiry_date' => 'nullable|date_format:d/m/Y',
            'no_of_users' => 'nullable|int|min:0',
        ];
    }
}