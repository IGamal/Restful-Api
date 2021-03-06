<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

trait ApiResponser
{
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function ShowAll(collection $collection, $code = 200)
    {
        if($collection->isEmpty())
        {
            return $this->successResponse(['$data' => $collection], $code);
        }

        $transformer = $collection->first()->transformer;

        $collection = $this->filterData($collection, $transformer);
        $collection = $this->sortData($collection, $transformer);
        $collection = $this->pagination($collection);
        $collection = $this->transformData($collection, $transformer);
        $collection = $this->cacheResponse($collection);

        return $this->successResponse($collection, $code);
    }

    protected function ShowOne(model $instance, $code = 200)
    {
        $transformer = $instance->transformer;
        $instance = $this->transformData($instance, $transformer);

        return $this->successResponse($instance, $code);
    }

    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }

    protected function filterData(Collection $collection, $transformer)
    {
        foreach (request()->query() as $query=> $value)
        {
            $attributes = $transformer::originalAttribute($query);

            if(isset($attributes, $value))
            {
                $collection = $collection->where($attributes, $value);
            }
        }
        return $collection;
    }

    protected function sortData(Collection $collection, $transformer)
    {
        if(request()->has('sort_by'))
        {
            $attribute = $transformer::originalAttribute(request()->sort_by);

            $collection = $collection->sortBy->{$attribute};
        }
        return $collection;
    }

    protected function pagination(Collection $collection)
    {
        $rules = [ 'per_page' => 'integer|min:5|max:50'];

        Validator::validate(request()->all(), $rules);

        $page = LengthAwarePaginator::resolveCurrentPage();

        $per_page = 15;
        if(request()->has('per_page')) { $per_page = request()->per_page;}

        $result = $collection->slice(($page - 1) * $per_page, $per_page)->values();

        $paginated = new LengthAwarePaginator($result, $collection->count(), $per_page, $page, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        $paginated->appends(request()->all());

        return $paginated;

    }

    protected function transformData($data, $transformer)
    {
        $transformation = fractal($data, new $transformer);

        return$transformation->toArray();
    }

    protected function cacheResponse($data)
    {
        $url = request()->url();

        $queryParams = request()->query();
        ksort($queryParams);
        $queryString = http_build_query($queryParams);
        $fullUrl = "{$url}?{$queryString}";

        return Cache::remember($fullUrl, 1, function() use($data)
        {
            return $data;
        });
    }
}
?>
