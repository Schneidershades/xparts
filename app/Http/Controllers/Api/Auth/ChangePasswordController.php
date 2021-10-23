<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordFormRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Rules\CurrentPassword;

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
     * )
     */

    public function __invoke(ChangePasswordFormRequest $request)
    {
        $user = User::find(auth()->user()->id);
        $user->password = bcrypt($request['password']);
        $user->save();

        return $this->showMessage('your password has been changed');

        // if(auth()->user()){
        //     $this->validate($request, [
        //         'password_current' => ['required', new CurrentPassword() ],
        //         'password' => 'required|string|min:6|confirmed',
        //     ]);
        //     $phoneUser = auth()->user()->id;

        // }else{
        //     $this->validate($request, [
        //         'password' => 'required|string|min:6|confirmed',
        //     ]);

        //     $phone = $request->phone;
        //     $phoneUser = User::where('phone', $phone)->first();
        // }

    

        // return $this->errorResponse($phoneUser->phone .' '. $request->password , 400);

        // $user = $phoneUser;
        // $user->password = bcrypt($request->password);
        // $user->save();

        // return $this->showMessage('your password has been changed');
    }
}
