<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Role;
use App\Models\User;
use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\User\PasswordUpdatedMail;
use App\Http\Requests\Admin\UserUpdateFormRequest;
use App\Http\Requests\Admin\StoreAdminOperatorRequest;
use App\Http\Requests\Admin\UpateChangePasswordRequest;
use App\Http\Requests\Admin\UpdateAdminOperatorRequest;

class AdminOperatorController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/admin/operators",
    *      operationId="allUsersOperator",
    *      tags={"Admin"},
    *      summary="Get all users Operator",
    *      description="Get all users Operator",
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
        $roles = Role::whereNotIn('name', ['User', 'Vendor'])->pluck('name')->toArray();
        return $this->showAll(User::role($roles)->dateFilter(\request()->date)->get());
    }

    /**
    * @OA\Post(
    *      path="/api/v1/admin/operators",
    *      operationId="postUser",
    *      tags={"Admin"},
    *      summary="Post users Operator",
    *      description="Post users Operator",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/StoreAdminOperatorRequest")
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
    public function store(StoreAdminOperatorRequest $request)
    {
        $user = User::create($request->validated());

        if($request['role']){
            $user->assignRole($request['role']);
        }

        return $this->showOne($user);
    }

    /**
    * @OA\Get(
    *      path="/api/v1/admin/operators/{id}",
    *      operationId="showUser",
    *      tags={"Admin"},
    *      summary="Show user Operator",
    *      description="Show user Operator",
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
    *      path="/api/v1/admin/operators/{id}",
    *      operationId="UserUpdateOperator",
    *      tags={"Admin"},
    *      summary="Update user Operator",
    *      description="Update user Operator",
    *
     *      @OA\Parameter(
     *          name="id",
     *          description="user Operator ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/UpdateAdminOperatorRequest")
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

    public function update(UpdateAdminOperatorRequest $request, User $user)
    {
        ($user->update($request->validated()));

        if($request['role']){
            $user->assignRole($request['role']);
        }

        return $this->showOne($user);
    }

     /**
    * @OA\Delete(
    *      path="/api/v1/admin/operators/{id}",
    *      operationId="deleteUserOperator",
    *      tags={"Admin"},
    *      summary="Delete user Operator",
    *      description="Delete user Operator",
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
    *      path="/api/v1/admin/operators/password/{id}",
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
