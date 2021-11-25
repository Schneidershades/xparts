<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Store Fcm Push Subscription  Form Request Fields",
 *      description="Store Fcm Push Subscription Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */

class StoreFcmPushSubscriptionRequest extends FormRequest
{

    /**
     * @OA\Property(
     *      title="FCM Token",
     *      description="fcm_token",
     *      example="seatbelt holder"
     * )
     *
     * @var string
     */
    public $fcm_token;

    /**
     * @OA\Property(
     *      title="Topic",
     *      description="topic",
     *      example=""
     * )
     *
     * @var string
     */
    public $topic;

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
            'fcm_token' => 'required|string',
            'topic' => 'nullable|string'
        ];
    }
}
