<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    /**
     * @var Request
     */
    protected $request;
    protected $builder;
    protected $filters = [];

    /**
     * Filters constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if(method_exists($this, $filter))
                $this->$filter($value);
        }

        foreach ($this->filters as $filter) {
            if($this->request->has($filter))
                $this->builder->where($filter, $this->request->get($filter));
        }

        return $this->builder;
    }

    private function getFilters()
    {
        return $this->request->intersect(get_class_methods($this));
    }
}