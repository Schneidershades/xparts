<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/user/orders",
    *      operationId="allOrders",
    *      tags={"User"},
    *      summary="allOrders",
    *      description="allOrders",
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
        return $this->showAll(auth()->user()->orders->latest()->get());
    }

    /**
    * @OA\Get(
    *      path="/api/v1/user/orders/{id}",
    *      operationId="showOrders",
    *      tags={"User"},
    *      summary="showOrders",
    *      description="showOrders",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="Order ID",
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
    public function show($id)
    {
        return $this->showOne(auth()->user()->orders->where('id', $id)->first());
    }

    public function store(Request $request)
    {
        return $this->showOne(auth()->user()->orders()->create($request->validated()));
    }

    public function update(Request $request, $id)
    {
        return $this->showOne(auth()->user()->orders()->create($request->validated()));
    }
}

// orderitems
// itemable_type
// itemable_id
// quantity

// update from payment gateway

// $table->string('receipt_number')->nullable(); 
// $table->foreignId('address_id')->nullable()->constrained();       
// $table->integer('vat_id')->index()->unsigned()->nullable();
// $table->integer('discount_id')->index()->unsigned()->nullable();
// $table->float('subtotal')->nullable();
// $table->string('orderable_type')->nullable();
// $table->integer('orderable_id')->nullable();
// $table->float('total')->nullable();
// $table->float('amount_paid')->nullable();
// $table->float('discount_amount')->nullable();
// $table->string('action')->nullable();
// $table->integer('currency_id')->nullable();
// $table->string('currency')->nullable();
// $table->string('payment_method')->nullable();
// $table->string('payment_gateway')->nullable();
// $table->float('payment_gateway_charged_percentage')->nullable();
// $table->float('payment_gateway_expected_charged_percentage')->nullable();
// $table->string('payment_reference')->nullable();
// $table->float('payment_gateway_charge')->default(0);
// $table->float('payment_gateway_remittance')->default(0);
// $table->string('payment_code')->nullable();
// $table->string('payment_message')->nullable();
// $table->string('payment_status')->default('pending');
// $table->string('platform_initiated')->nullable();
// $table->string('transaction_initiated_date')->nullable();
// $table->string('transaction_initiated_time')->nullable();
// $table->date('date_time_paid')->nullable();
// $table->date('date_cancelled')->nullable();
// $table->text('cancelled_cancel')->nullable();
// $table->string('service_status')->default('pending');
// $table->string('status')->default('pending');