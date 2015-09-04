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

    static public function deleteBlogTag($tagId)
    {
        return static::where('tag_id', $tagId)->delete();
    }
}
