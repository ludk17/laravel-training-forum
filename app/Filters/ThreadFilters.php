<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
    protected $filters = ['user_id'];
    /**
     * @param string $username
     *
     * @return mixed
     */
    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->whereUserId($user->id);
    }

    public function title($title)
    {
        $this->builder->whereTitle($title);
    }

}