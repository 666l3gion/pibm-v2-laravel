<?php

namespace App\Traits;

use Illuminate\Support\Arr;

trait Filterable
{
    protected string $keySearchFilter = "search";
    protected string $keySort = "sort";
    protected string $keySortDirection = "direction";

    protected array $searchableColumns = [];
    protected array $validSortColumns = [];
    protected array $validSortDirections = ['asc', 'desc'];

    public function setFilterableProperties(array $searchableColumns, array $validSortColumns)
    {
        $this->searchableColumns = $searchableColumns;
        $this->validSortColumns = $validSortColumns;
    }

    private function getWheres($value): array
    {
        $wheres = [];
        foreach ($this->searchableColumns as $key) {
            $wheres[] = [$key, 'LIKE', "%$value%", "or"];
        }
        return $wheres;
    }

    /**
     * 
     */
    private function isSortDataValid(array $filters): bool
    {
        return Arr::has($filters, $this->keySort) && in_array($filters[$this->keySort], $this->validSortColumns);
    }

    /**
     * 
     */
    private function isSortDirectionDataValid(array $filters): bool
    {
        return Arr::has($filters, $this->keySortDirection) && in_array($filters[$this->keySortDirection], $this->validSortDirections);
    }

    public function filter(\Illuminate\Database\Eloquent\Builder $query, array $filters)
    {
        // handle search
        $query->when(
            $filters[$this->keySearchFilter] ?? false,
            fn ($query, $value) =>
            $query
                ->where(
                    $this->getWheres($value)
                )
        );

        // handling sorting data
        // default sort by created_at
        $filters['sort'] = [
            'column' => $this->isSortDataValid($filters) ? $filters[$this->keySort] : "created_at",
            'direction' => $this->isSortDirectionDataValid($filters) ? $filters[$this->keySortDirection] : "desc"
        ];

        $query->when(
            $filters['sort'] ?? false,
            fn ($query, $sort) =>
            $query->orderBy($sort['column'], $sort['direction'])
        );
    }
}
