<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
Use Illuminate\Http\Request;
// use App\Http\Requests\Auth\ResetPasswordRequest;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

     /**
    * @OA\Post(
    *      path="/api/v1/user/password/email",
    *      operationId="sendResetMailForgotPassword",
    *      tags={"authentication"},
    *      summary="reset a registered user password",
    *      description="Returns a registered user reset email",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/ForgotPasswordRequest")
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful signin",
    *          @OA\MediaType(
    *             mediaType="application/json",
    *         ),
    *       ),
    *      @OA\Response(
    *          response=400,
    *          description="Bad Request"
    *      ),
    *      @OA\Response(
    *          response=401,
    *          description="Unauthenticated",
    *      ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      ),
    * )
    */

    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response(['message' => $response]);
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response(['error'=> $response], 422);
    }
}
