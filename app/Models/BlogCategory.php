<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BlogCategory
 *
 * @package App\Models
 *
 * @parenty-read BlogCategory $parentCategory
 * @parenty-read string         $parentTitle
 *
 *
 *
 */

class BlogCategory extends Model
{

    use SoftDeletes;

    const ROOT = 1;
    protected $fillable
        = [
            'id',
            'title',
            'slug',
            'parent_id',
            'description',
        ];



    /**
     * Получить родительскую категорию
     *
     * @return BelongsTo
     *
     */

    public function parentCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id', 'id');
    }



    /**
     * @inheritDoc
     */
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }
    public function getParentTitleAttribute()
    {
        $title = $this->parentCategory->title
            ?? ($this->isRoot()
                ? 'Корень'
                : '???');
        return $title;
    }

    /**
     * Являеться ли текущий объект корневым
     *
     * @return bool
     */
    public function isRoot()
    {
        return $this->id === BlogCategory::ROOT;
    }

    /**
     * Пример аксесуара
     *
     * @param $valueFromObject
     * @return bool|false|string|string[]|null
     */

    public function getTitleAttribute($valueFromObject)
    {
        return mb_strtoupper($valueFromObject);
    }

    /**
     * Пример мутатора
     *
     * @param  string $incomigValue
     */

    public function setTitleAttribute($incomigValue)
    {
        $this->attributes['title'] = mb_strtolower($incomigValue);
    }
}




