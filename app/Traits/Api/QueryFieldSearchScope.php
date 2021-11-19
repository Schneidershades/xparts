<?php
namespace App\Traits\Api;

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

trait QueryFieldSearchScope
{
    public function scopeSearch($query, $searchables=null){
        $searchQuery = request()->get('search');

        if (is_null($searchQuery)){
            return $query;
        }
        $tableName = $this->getTable();
        if(!is_null($searchables)){
            if (!is_array($searchables)){
                $searchables = (array)$searchables;
            }
        }
        elseif (!property_exists($this, 'searchables')){
            $searchables = Schema::getColumnListing($tableName);
        }else{
            $searchables = $this->searchables;
        }

        $builder = $query;
        foreach ($searchables as $key => $field) {
            if ($key === 0){
                $builder->where($field, 'like', "%{$searchQuery}%");
            }else{
                $builder->orWhere($field, 'like', "%{$searchQuery}%");
            }

        }
        return $builder;
    }

    public function scopeSearchRelatedModels($query, $search_query, array $relatedModels=[])
    {
        foreach ($relatedModels as $relatedModel)
        {
            $query->whereHas($relatedModel, function($builder) use ($search_query, $relatedModel)
            {
                $relatedModelClass = $this->$relatedModel()->getRelated();

                $searchables = (new $relatedModelClass)->searchables;

                foreach ($searchables as $key => $field) 
                {
                    
                    $builder->where($field, 'like', "%{$search_query}%");
                    if ($key === 0) {
                        $builder->where($field, 'like', "%{$search_query}%");
                    } else {
                        $builder->orWhere($field, 'like', "%{$search_query}%");
                    }
                }

                
                return $builder;
            });
        }
        
        return $query;
    }

    public function scopeSearchRelatedIdModels($query, $search_query, array $relatedModels=[])
    {
        foreach ($relatedModels as $relatedModel)
        {
            $query->whereHas($relatedModel, function($builder) use ($search_query, $relatedModel)
            {
                $relatedModelClass = $this->$relatedModel()->getRelated();

                $searchables = (new $relatedModelClass)->searchables;

                foreach ($searchables as $key => $field) 
                {
                    if ($key === 0) {
                        $builder->where($field, 'like', "%{$search_query}%");
                    } else {
                        $builder->orWhere($field, 'like', "%{$search_query}%");
                    }
                }

                return $builder;
            });
        }
        
        return $query;
    }

    public function scopeApplyFilter($query, $field, $value)
    {
        if (is_null($field) OR is_null($value)){
            return $query;
        }
        return $query->where($field, $value);
    }

    public function scopeApplySort($query, $field, $order="ASC"){
        if (is_null($field) or is_null($order)) {
            return $query;
        }

        return $query->orderBy($field, $order);
    }

    /**
     * @param $query
     * @param mixed $date
     */
    public function scopeDateFilter($query, $date, $field='created_at'){

        if ($date == "today"){
            $query->whereDate($field, Carbon::today());
        }
        elseif ($date == "yesterday"){
            $query->whereDate($field, Carbon::yesterday());
        }
        elseif ($date == "month"){
            $query->whereYear($field, Carbon::now()->year)
                ->whereMonth($field, Carbon::now()->month);
        }
        elseif ($date == "year"){
            $query->whereYear($field, Carbon::now()->year);
        }
        elseif (is_array($date) && count($date) > 0){
            try {
                $query->whereDate($field, '>=', Carbon::parse($date[0]))
                    ->whereDate($field, '<=', Carbon::parse($date[1]) ?? Carbon::today());
            } catch (\Throwable $th) {
                //throw $th;
                return $query;
            }
            
        }
        elseif (strtotime($date)) {
            $query->whereDate($field, Carbon::parse($date)->toDateString());
        }

        return $query;
    }
}
