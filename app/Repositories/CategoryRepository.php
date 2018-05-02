<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\BaseInterfaceRepository;

class CategoryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Category::class);
    }
}
