<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Page;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PageCreateFormRequest;
use App\Http\Requests\Admin\PageUpdateFormRequest;

class PageController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/admin/pages",
    *      operationId="allPages",
    *      tags={"Admin"},
    *      summary="Get all pages",
    *      description="Get all pages",
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
        return $this->showAll(Page::all());
    }

    /**
    * @OA\Post(
    *      path="/api/v1/admin/pages",
    *      operationId="postPage",
    *      tags={"Admin"},
    *      summary="Post pages",
    *      description="Post pages",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/PageCreateFormRequest")
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
    public function store(PageCreateFormRequest $request)
    {
        $part = Page::create([
            "name" => $request['name'],
            "slug" => Str::slug($request['name'], '-'),
            "excerpt" => $request['excerpt'],
            "description" => $request['description'],
        ]);

        return $this->showOne($part);
    }

    /**
    * @OA\Get(
    *      path="/api/v1/admin/pages/{id}",
    *      operationId="showPage",
    *      tags={"Admin"},
    *      summary="Show pages",
    *      description="Show pages",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="pages ID",
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
        return $this->showOne(Page::findOrFail($id));
    }

    /**
    * @OA\Put(
    *      path="/api/v1/admin/pages/{id}",
    *      operationId="UpdatePage",
    *      tags={"Admin"},
    *      summary="Update pages",
    *      description="Update pages",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="pages ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/PageUpdateFormRequest")
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
    
    public function update(PageUpdateFormRequest $request, Page $page)
    {
        $page->update([
            "name" => $request['name'],
            "slug" => Str::slug($request['name'], '-'),
            "excerpt" => $request['excerpt'],
            "description" => $request['description'],
        ]);
        return $this->showOne($page);
    }

     /**
    * @OA\Delete(
    *      path="/api/v1/admin/pages/{id}",
    *      operationId="deletePage",
    *      tags={"Admin"},
    *      summary="Delete pages",
    *      description="Delete pages",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="pages ID",
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
    public function destroy(Page $page)
    {
        $page->delete();
        return $this->showMessage('deleted');
    }
}
