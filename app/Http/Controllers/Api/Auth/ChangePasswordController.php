<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\CurrentPassword;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordFormRequest;

class ChangePasswordController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/v1/auth/change/password",
     *      operationId="changepassword",
     *      tags={"authentication"},
     *      summary="change password for user",
     *      description="change password of registered user data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ChangePasswordFormRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful password change",
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
    *      security={ {"bearerAuth": {}} },
     * )
     */

    public function __invoke(ChangePasswordFormRequest $request)
    {
        User::find(auth()->user()->id)->update(['password'=> bcrypt($request->password)]);
        return $this->showMessage('your password has been changed');
    }
}
