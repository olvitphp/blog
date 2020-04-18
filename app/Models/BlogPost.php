<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BlogPost
 * @package App\Models
 *
 * @property BlogCategory $category
 * @property User                      $user
 * @property string                    $title
 * @property string                    $slug
 * @property string                    $content_html
 * @property string                    $content_raw
 * @property string                    $excerpt
 * @property string                    $published_it
 * @property string                    $is_published
 *
 */

class BlogPost extends Model
{
    use SoftDeletes;

    const UNKNOWN_USER =1;

    protected $fillable
        = [
            'title',
            'slug',
            'category_id',
            'excerpt',
            'content_raw',
            'is_published',
            'published_at',

        ];

    /**
     * Кктегория статьи.
     *
     * @return BelongsTo
     *
     */
    public function category()
    {
        // СТАТЬИ ПРИНАДЛЕЖАТ КАТЕГОРИИ
        return $this->belongsTo(BlogCategory::class);
    }

    /**
     *  // Автор статьи.
     *
     * @return BelongsTo
     */

    public function user()
    {
        // Статья принадлежит пользователю
        return $this->belongsTo(User::class);
    }

    /**
     * @inheritDoc
     */
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }



}
