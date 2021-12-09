<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\User\PasswordUpdatedMail;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Models\UserRepository;
use App\Http\Requests\Admin\UserUpdateFormRequest;
use App\Http\Requests\Admin\UpateChangePasswordRequest;

class UserController extends Controller
{
    public $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
    * @OA\Get(
    *      path="/api/v1/admin/users",
    *      operationId="allUsers",
    *      tags={"Admin"},
    *      summary="Get all users",
    *      description="Get all users",
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
    *          description="unauthenticated",
    *      ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      ),
    *      security={ {"bearerAuth": {}} },
    * )
    */
    public function index()
    {
        return $this->showAll($this->userRepo->all());
    }

    /**
    * @OA\Post(
    *      path="/api/v1/admin/users",
    *      operationId="postUser",
    *      tags={"Admin"},
    *      summary="Post users",
    *      description="Post users",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/UserCreateFormRequest")
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
    *          description="unauthenticated",
    *      ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      ),
    *      security={ {"bearerAuth": {}} },
    * )
    */
    public function store(Request $request)
    {
        return $this->showOne(auth()->user()->users->create($request->validated()));
    }

    /**
    * @OA\Get(
    *      path="/api/v1/admin/users/{id}",
    *      operationId="showUser",
    *      tags={"Admin"},
    *      summary="Show user",
    *      description="Show user",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      
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
    *          description="unauthenticated",
    *      ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      ),
    *      security={ {"bearerAuth": {}} },
    * )
    */
    public function show($id)
    {
        return $this->showOne(User::findOrFail($id));
    }

    /**
    * @OA\Put(
    *      path="/api/v1/admin/users/{id}",
    *      operationId="UserUpdate",
    *      tags={"Admin"},
    *      summary="Update user",
    *      description="Update user",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="user ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/UserCreateFormRequest")
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
    *          description="unauthenticated",
    *      ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      ),
    *      security={ {"bearerAuth": {}} },
    * )
    */
    
    public function update(UserUpdateFormRequest $request, User $user)
    {
        ($user->update($request->validated()));
        return $this->showOne($user);
    }

     /**
    * @OA\Delete(
    *      path="/api/v1/admin/users/{id}",
    *      operationId="deleteUser",
    *      tags={"Admin"},
    *      summary="Delete user",
    *      description="Delete user",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
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
    *          description="unauthenticated",
    *      ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      ),
    *      security={ {"bearerAuth": {}} },
    * )
    */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->showMessage('deleted');
    }

    /**
    * @OA\Put(
    *      path="/api/v1/admin/users/password/{id}",
    *      operationId="UserUpdatePassword",
    *      tags={"Admin"},
    *      summary="Update user",
    *      description="Update user",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="user ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/UpateChangePasswordRequest")
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
    *          description="unauthenticated",
    *      ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      ),
    *      security={ {"bearerAuth": {}} },
    * )
    */
    
    public function changePassword(UpateChangePasswordRequest $request, $id)
    {
        $user = User::find($id);
        $user->update([
            'password' => bcrypt($request['password'])
        ]);

        SendEmail::dispatch($user->email, new PasswordUpdatedMail($user, $request['password']))->onQueue('emails')->delay(5);

        return $this->showMessage('password has been changed');
    }
}
