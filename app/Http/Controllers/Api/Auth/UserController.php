<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Auth\UserLoginFormRequest;
use App\Http\Requests\Auth\AuthUpdateFormRequest;
use App\Http\Requests\Auth\UserRegistrationFormRequest;

class UserController extends Controller
{
     /**
     * @OA\Post(
     *      path="/api/v1/auth/register",
     *      operationId="register",
     *      tags={"authentication"},
     *      summary="Sign Up a new user",
     *      description="Returns a newly registered user data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UserRegistrationFormRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful signup",
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
    public function register(UserRegistrationFormRequest $request)
    {
        $user = User::create($request->validated());

        $user->sendEmailVerificationNotification();

        if(!$token = auth()->attempt($request->only(['email', 'password']))){
            return $this->errorResponse('unauthenticated', 401);
        }

        return $this->respondWithToken($token);
    }

     /**
    * @OA\Post(
    *      path="/api/v1/auth/login",
    *      operationId="signIn",
    *      tags={"authentication"},
    *      summary="Sign In a registered user",
    *      description="Returns a newly registered user data",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/UserLoginFormRequest")
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
    public function login(UserLoginFormRequest $request)
    {
        if(!$token = auth()->attempt($request->only(['email', 'password']))){
            return $this->authErrorResponse('Could not sign you in with those details', 401);
        }

        return $this->respondWithToken($token);
    }

    /**
    * @OA\Post(
    *      path="/api/v1/auth/profile",
    *      operationId="updateUserProfile",
    *      tags={"authentication"},
    *      summary="Profile of a registered user",
    *      description="Profile of a registered user",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/UserUpdateFormRequest")
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
    *      security={ {"bearerAuth": {}} },
    * )
    */
    public function updateUser(AuthUpdateFormRequest $request){

        $model = User::find(auth()->user()->id);

        $this->requestAndDbIntersection($request, $model, []);

        $model->save();
        if($request->hasFile('image')){

            $s3 = Storage::disk('s3');
            $s3->delete('filename');
            
            $path = $this->uploadImage($request->image, "profile_photos");
            $model->avatar()->create([
                'file_path' => $path,
            ]);
        }

        return $this->showOne($model);
    }

    /**
    * @OA\Post(
    *      path="/api/v1/auth/refresh/token",
    *      operationId="userLogout",
    *      tags={"authentication"},
    *      summary="Refresh a registered user token",
    *      description="Refresh a registered user token",
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
    *      security={ {"bearerAuth": {}} },
    * )
    */

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
    * @OA\Post(
    *      path="/api/v1/auth/logout",
    *      operationId="userLogout",
    *      tags={"authentication"},
    *      summary="Logout a registered user",
    *      description="Logout a registered user",
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
    *      security={ {"bearerAuth": {}} },
    * )
    */

    public function logout()
    {
        auth()->logout();
    }

    /**
    * @OA\Get(
    *      path="/api/v1/auth/profile",
    *      operationId="userProfile",
    *      tags={"authentication"},
    *      summary="Profile of a registered user",
    *      description="Profile of a registered user",
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
    *      security={ {"bearerAuth": {}} },
    * )
    */
    public function profile()
    {
        $userId = auth()->user()->id; 
        return $this->showOne(User::with('avatar')->find($userId), 201);
    }
}
