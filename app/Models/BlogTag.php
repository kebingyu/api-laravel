<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    protected $connection = 'mysql';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'blog_tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['blog_id', 'tag_id'];

    static public function createBlogTag(array $data)
    {
        return static::create($data);
    }

    static public function deleteByTagId($id)
    {
        return static::where('tag_id', $id)->delete();
    }

    static public function deleteByTagAndBlogId($blogId, $tagId)
    {
        return static::where('tag_id', $tagId)
            ->where('blog_id', $blogId)->delete();
    }

    static public function deleteByBlogId($id)
    {
        return static::where('blog_id', $id)->delete();
    }

    static public function isOrphanTag($tagId)
    {
        return static::where('tag_id', $tagId)->count() == 0;
    }
}
