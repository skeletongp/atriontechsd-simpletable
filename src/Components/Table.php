<?php

namespace Atriontechsd\SimpleTable\Components;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Atriontechsd\SimpleTable\App\SearchTrait;
use Atriontechsd\SimpleTable\Styles\TableStyles;
use Livewire\WithPagination;

class Table extends Component
{
    protected $route;
    protected $tableName;
    public $columns = [];
    public $headers;
    public $params = [];
    public $emptyMessage = 'No data found';
    public $perPage = 10;
    public $page = 1;
    public $orderBy;
    public $orderDirection = 'asc';
    public $search = '';
    public $searcheables = [];
    public $hideables = [];
    public $page_name = 'page';
    public $title = 'Table from Atriontechsd/SimpleTable';
    public $hideable = false;


    public $next, $prev, $total, $from, $to, $currentPage;

    public bool $is_paginated = false;

    use SearchTrait, WithPagination, TableStyles;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
        'perPage' => ['except' => 10],
        'orderDirection' => ['except' => 'asc'],
        'orderBy' => ['except' => 'id'],
    ];

    protected $listeners = [
        'edit' => 'edit',
        'delete' => 'delete',
        'refreshSimpletable' => 'refreshSimpletable',
    ];

    public function mount()
    {
        if (!$this->columns) {
            $this->columns = $this->columns();
        }
        $this->setStyles();
        if (!$this->orderBy) {
            $this->orderBy = $this->setTable() . '.id';
        }
    }
    public function render()
    {
        $data = $this->builder();
        return view('simpletable::table', compact('data'));
    }
    public function refreshSimpletable()
    {
        $this->render();
    }

    public function builder()
    {
        $this->id = uniqid();

        $table = $this->setTable();
        $query = DB::table($table);
        $this->joins($query);
        $query->select($this->getFields());
        $this->whereNullDeletedAt($query);
        $this->addJoins($query);
        $this->search($query, $this->search);
        $this->order($query);
        $data = $this->getData($query);
        return $data;
    }
    public function getData($query)
    {
        $data = $query->paginate($this->perPage, ['*'], $this->page_name, $this->page);
        $this->next = $data->nextPageUrl();
        $this->prev = $data->previousPageUrl();
        $this->total = $data->total();
        $this->from = $data->firstItem();
        $this->to = $data->lastItem();
        $this->lastPage = $data->lastPage();
        $this->currentPage = $data->currentPage();
        return $data;
    }

    public function whereNullDeletedAt($query)
    {
        $table = DB::table($this->setTable());
        $columns = $table->getConnection()->getSchemaBuilder()->getColumnListing($this->setTable());
        if (in_array('deleted_at', $columns)) {
            $query->whereNull($this->setTable() . '.deleted_at');
        }
    }

    public function addJoins(Builder $query)
    {
        $joins = $this->joins();
        foreach ($joins as $table => $join) {
            //table remove non letters
            $table = preg_replace('/[^A-Za-z\-]/', '', $table);
            if (array_key_exists('alias', $join)) {
                //set table alias on join query
                $query->leftjoin($table . ' as ' . $join['alias'], $join['alias'] . '.' . $join[0], '=', $this->setTable() . '.' . $join[1]);
            } else {
                $query->leftjoin($join[0], '=', $join[1]);
            }
        }
    }
    public function order(Builder $query)
    {
        $query->orderBy($this->orderBy, $this->orderDirection);
    }


    public function setOrder($sortable, $column)
    {
        if ($sortable) {
            if ($this->orderBy == $column) {
                if ($this->orderDirection == 'asc') {
                    $this->orderDirection = 'desc';
                } else {
                    $this->orderDirection = 'asc';
                }
            } else {
                $this->orderBy = $column;
                $this->orderDirection = 'asc';
            }
        }
        $this->render();
    }
    public function getFields()
    {
        //get key name from columns and make array whre type not is edit
        if (is_array($this->columns)) {
            $this->columns = json_decode(json_encode($this->columns));
        }

        $columns = array_filter($this->columns, function ($column) {
            return $column->type != 'edit';
        });
        $this->searcheables = [];
        $this->hideables = [];
        $fields = array_map(function ($column) {
            //column searcheable add to searcheables array

            if ($column->searchable) {
                array_push($this->searcheables, [
                    'name' => $column->name,
                    'label' => $column->label
                ]);
            }
            if ($column->hideable) {
                array_push($this->hideables, [
                    'alias' => $column->alias,
                    'label' => $column->label,
                    'status' => $column->hidden
                ]);
            }

            return $column->name . ' as ' . $column->alias;
        }, $columns);
        return $fields;
    }


    public function makeColumns()
    {
        //if data is empty, return empty array
        if (!$this->builder()) {
            return [];
        }
        $data = $this->builder()[0];
        foreach ($this->columns as $column) {
            //if column name has dot, get last part of string after dot

            if (!isset($data->{$column->alias})) {
                throw new \Exception("Column {$column->alias} not found in data. Check aliases");
            }
        }
    }

    public function sumarize($column)
    {
    }



    public function updatingPage($value)
    {
        if ($value > $this->lastPage) {
            $this->page = $this->lastPage;
        }
    }

    public function toggleHide($alias)
    {
        foreach ($this->columns as $index => $column) {
            if ($column['alias'] == $alias) {
                $this->columns[$index]['hidden'] = !$this->columns[$index]['hidden'];
            }
        }

        $this->render();
    }
}
