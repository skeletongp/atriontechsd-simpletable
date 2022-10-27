<?php

namespace Atriontechsd\SimpleTable;

use Illuminate\Contracts\Database\Query\Builder;

trait SearchTrait
{
    public function updatedSearch($value)
    {
        
        $this->page = 1;
    }
    public function search(Builder $query, $search)
    {
        $query->where(function ($query) use ($search) {
            foreach ($this->columns as $column) {
                if ($column->searchable) {
                    //query full search in column name with search value with all posible operators
                    $terms = explode(' ', $search);
                    foreach ($terms as $term) {
                        $query->orWhere($column->name, 'like', '%' . $term . '%');
                        $query->orWhere($column->name, 'like', $term . '%');
                        $query->orWhere($column->name, 'like', '%' . $term);
                        $query->orWhere($column->name, '=', $term);
                    }
                }
            }
        });
    }
}
