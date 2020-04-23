<?php

namespace App\Repositories;

//use Your Model
use App\Models\BlogCategory as Model;
use Barryvdh\Reflection\DocBlock\Type\Collection;

// use Illuminate\Database\Eloquent\Model;

/**
 * Class BlogCategoryRepository.
 * @package App\Repository
 */
class BlogCategoryRepository extends CoreRepository
{
    /**
     * @return string
     *  Return the model
     */
    protected function getModelClass()
    {
        return Model::class;
    }
//    public function model()
//    {
//       // return YourModel::class;
//    }

    /**
     * @param int $id
     * @return mixed
     */

    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }
    /**
     *  Получить список категорий для вывода в выпадающем списке
     * @return Collection
     *
     */

    public function getForComboBox()
    {
        //   return $this->startConditions()->all();

        $columns = implode(', ', [
            'id',
            'CONCAT (id, ". ", title) AS id_title',
        ]);

        $result[] = $this->startConditions()->all();
        //   dd($result);
       // $result[] = $this
//            ->startConditions()
//            ->select('blog_categories.*',
//                \DB::raw( 'CONCAT (id, ". ", title) AS id_title'))
//            ->toBase()
//            ->get();

        $result = $this
            ->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();
         // dd($result);
        return $result;
    }

    /**
     * Получить категории для вывода пагинаторм
     *
     * @param null $perPage
     * @return mixed
     */

    public function getAllWithPaginate($perPage = null)
    {
        $columns = ['id', 'title', 'parent_id'];

        $result = $this
            ->startConditions()
            ->select($columns)
            ->with([
                'parentCategory:id,title',
            ])

            ->paginate($perPage);
// dd($result);
        return $result;
    }

}
