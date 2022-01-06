<?php

namespace App\Repositories\Models;

use App\Models\DeliveryRate;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\ApplicationRepository;

class OrderItemRepository extends ApplicationRepository
{
    public function builder(): Builder
    {
        $search_query = request()->get('search') ? request()->get('search') : null;

        return DeliveryRate::query()
                    ->selectRaw('delivery_rates.*')
                    ->when($search_query, function (Builder $builder, $search_query) {
                        $builder->where('delivery_rates.id', 'LIKE', "%{$search_query}%")
                        ->orWhere('delivery_rates.destinatable_id', 'LIKE', "%{$search_query}%")
                        ->orWhere('delivery_rates.destinatable_type', 'LIKE', "%{$search_query}%");
                    })->latest();
    }

    public function fetchDeliveryRate($id)
    {
        return $this->builder->where('delivery_rates.id', '=', $id)->first();
    }

    public function deliveryRateSettings($address)
    {
        return match($address) {
            'c' => DeliveryRate::where('destinatable_id', $address->country_id)->where('destinatable_type', 'countries')->first(),
            'b' => DeliveryRate::where('destinatable_id', $address->state_id)->where('destinatable_type', 'states')->first(),
            'a' => DeliveryRate::where('destinatable_id', $address->city_id)->where('destinatable_id', 'cities')->first(),
            default => DeliveryRate::where('type', 'flat')->first(),
        };

        // if($address->city_id){
        //     $deliverySetting = DeliveryRate::where('destinatable_id', $address->city_id)
        //                         ->where('destinatable_id', 'cities')
        //                         ->first();
        // }elseif($address->state_id){
        //     $deliverySetting = DeliveryRate::where('destinatable_id', $address->state_id)
        //                         ->where('destinatable_type', 'states')
        //                         ->first();
        // }elseif($address->country_id){
        //     $deliverySetting = DeliveryRate::where('destinatable_id', $address->country_id)
        //                         ->where('destinatable_type', 'countries')
        //                         ->first();
        // }else{
        //     $deliverySetting = DeliveryRate::where('type', 'flat')->first();
        // }

        // return $deliverySetting;
    }
}