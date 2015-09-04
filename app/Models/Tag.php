<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BlogTag;

class Tag extends Model
{
    protected $connection = 'mysql';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['content'];

    static public function createTag(array $data)
    {
        $tag = static::create($data);
        if ($tag)
        {
            $data['tag_id'] = $tag->id;
            $blogTag = BlogTag::createBlogTag($data);
            if ($blogTag)
            {
                return $tag;
            }
        }
        return false;
    }

    static public function deleteByTag(array $data, $tagId)
    {
        if (BlogTag::deleteBlogTag($tagId))
        {
            return static::destroy($tagId);
        }
        return false;
    }

    /**
     * Build relationship with "blog" table through pivot table "blog_tag"
     * 
     * @return Collections
     */
    public function blogs()
    {
        return $this->belongsToMany('App\Models\Blog', 'blog_tag', 'tag_id', 'blog_id');
    }
}
