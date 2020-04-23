<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class BlogUserRepository.
 */
class BlogUserRepository extends CoreRepository
{


    /**
     * @inheritDoc
     */
    protected function getModelClass()
    {
        return Model::class;
    }
}
