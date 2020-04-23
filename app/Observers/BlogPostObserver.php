<?php
namespace App\Providers;
namespace App\Observers;


use App\Models\BlogPost;
use Carbon\Carbon;



class BlogPostObserver
{


    /**
     * Handle the blog post "created" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function creating(BlogPost $blogPost)
    {
        $this->setPublishedAt($blogPost);

        $this->setSlug($blogPost);

        $this->setHTML($blogPost);

        $this->setUser($blogPost);

    }



    /**
     * Если дата публикации не установлена и происходит установка флага - Опубликовано,
     *  то устанавливает дату публикации на текущую.
     * @param BlogPost $blogPost
     */
    protected function setPublishedAt(BlogPost $blogPost)
    {


        $needSetPublished = empty($blogPost->published_at)
            && $blogPost->is_published;

        if ($needSetPublished) {
            $blogPost->published_at = Carbon::now();
        }
    }

    /**
     * Если поле слаг пустое, то заполняем его ковертацией заголовка.
     *
     * @param BlogPost $blogPost
     *
     * @return void
     */

    protected function setSlug(BlogPost $blogPost)

    {


        if (empty($blogPost->slug)) {
            $blogPost->slug = \Str::slug($blogPost->title);

        }

    }
    protected function setHTML(BlogPost $blogPost)
    {
        if ($blogPost->isDirty('content_raw')) {
            // TODO: Тут должна быть генерация markdown -> html
            $blogPost->content_html = $blogPost->content_raw;
        }
    }

    /**
     * Если не установлен user_id, то устанавливаем пользователя по-умолчанию
     *
     * @param BlogPost $blogPost
     */

    protected function setUser(BlogPost $blogPost)
    {
        $blogPost->user_id = auth()->id() ?? BlogPost::UNKNOWN_USER;

    }
    /**
     *  Обработка перед обновлением записи
     * Handle the blog post "updated" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function updating(BlogPost $blogPost)
    {

        $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost);
    }
    public function updated(BlogPost $blogPost)
    {

    }

    /**
     * @param BlogPost $blogPost
     */
    public function deleting(BlogPost $blogPost)
    {

        // dd(__METHOD__, $blogPost);
        //  return false;
    }

    /**
     * Handle the blog post "deleted" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function deleted(BlogPost $blogPost)
    {
        // dd(__METHOD__, $blogPost);
    }

    /**
     * Handle the blog post "restored" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function restored(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "force deleted" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function forceDeleted(BlogPost $blogPost)
    {
        //
    }
}
