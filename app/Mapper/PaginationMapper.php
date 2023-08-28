<?php

namespace App\Mapper;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class PaginationMapper
{
    /**
     * Undocumented function
     *
     * @param array $options
     * @param [type] $items
     * @return array
     */
    public function metaPagination(array $options = [],$items): array
    {
        return [
            'current_page' => $items->currentPage(),
            'first_page_url' => $items->url(1),
            'from' => $items->firstItem(),
            'last_page' => $items->lastPage(),
            'last_page_url' => $items->url($items->lastPage()),
            'next_page_url' => $items->nextPageUrl(),
            'per_page' => $items->perPage(),
            'prev_page_url' => $items->previousPageUrl(),
            'path' => $items->path(),
            'to' => $items->lastItem(),
            'total' => $items->total(),
        ];
    }

    /**
     * Undocumented function
     *
     * @param array $options
     * @param [type] $items
     * @return array
     */
    public function metaArray(array $options = [],$items): array
    {
        $page = $options['page'] ?? 1;
        $perPage = $options['per_page'] ?? 10;


        $page = $options['page'] ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        $lap = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count, $perPage, $page, $options);

        return [
            'current_page' => $lap->currentPage(),
            'first_page_url' => $lap ->url(1),
            'from' => $lap->firstItem(),
            'last_page' => $lap->lastPage(),
            'last_page_url' => $lap->url($lap->lastPage()),
            'next_page_url' => $lap->nextPageUrl(),
            'per_page' => $lap->perPage(),
            'prev_page_url' => $lap->previousPageUrl(),
            'path' => $lap->path(),
            'to' => $lap->lastItem(),
            'total' => $lap->total(),
        ];
    }
}
