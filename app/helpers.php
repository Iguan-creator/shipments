<?php


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

if (! function_exists('jsonResponse')) {
    
    /**
     * Return standard json repsonse with utf-8 unescaped
     *
     * @param $data
     * @return JsonResponse
     */
    function jsonResponse($data)
    {
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }
}

if (! function_exists('addCheckedToCollection')) {

    /**
     * Add 'checked' field to a collection of models
     *
     * @param Collection $collection
     * @param Collection $checked_ids
     */
    function addCheckedToCollection(Collection $collection, Collection $checked_ids)
    {
        $collection->map(function ($item) use ($checked_ids) {
            $item->checked = $checked_ids->contains($item->id);
            return $item;
        });
    }
}
