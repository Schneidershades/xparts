<?php

namespace App\Cart;

use App\Models\User;

class Cart 
{
	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function products()
	{
		return auth()->user()->cart;
	}

	public function add($products)
	{
    	auth()->user()->cart()->syncWithoutDetaching(
    		$this->getStorePayload($products)
    	);
	}

	public function update($productId, $quantity)
	{
    	auth()->user()->cart()->updateExistingPivot(
    		$productId, [
    		'quantity' => $quantity,
    	]);
	}

	public function delete($productId)
	{
		auth()->user()->cart()->detach($productId);
	}

	public function empty()
	{
		auth()->user() ? auth()->user()->cart()->detach() : '';
	}

	public function isEmpty()
	{
		return auth()->user()->cart->sum('pivot.quantity') === 0;
	}


	public function subTotal()
	{
		$subtotal = auth()->user()->cart->sum(function($product){
			return $product->amount * $product->pivot->quantity;
		});

		return $subtotal;
	}

	protected function getStorePayload($products)
	{
		return collect($products)->keyBy('id')->map(function($product){
    		return [
    			'quantity' => $product['quantity'] + $this->getCurrentQuantity($product['id']),
    		];
    	})->toArray();
	}

	protected function getCurrentQuantity($productId)
	{
		if($product = auth()->user()->cart->where('id', $productId)->first()){
			return $product->pivot->quantity;
		}

		return 0;
	}

}