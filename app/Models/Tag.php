<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BlogTag;
use App\Models\User;

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
    protected $fillable = ['content', 'user_id'];

    static public function createTag(array $data)
    {
        // First check if tag with same content 
        // is already being used by this blog
        if ($tag = static::usedByBlog($data, $data['content']))
        {
            return true;
        }
        // Second check if tag with same content
        // is already created by this user
        // Else create a new one
        if (
            ($tag = static::createdByUser($data['user_id'], $data['content']))
            || ($tag = static::create($data))
        )
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

    static protected function createdByUser($userId, $content)
    {
        if ($user = User::find($userId))
        {
            if ($tag = $user->tags()->where('content', $content)->first())
            {
                return $tag;
            }
        }
        return false;
    }

    static protected function usedByBlog(array $data, $content)
    {
        if ($blog = Blog::findViewable($data, $data['blog_id']))
        {
            if ($tag = $blog->tags()->where('content', $content)->first())
            {
                return $tag;
            }
        }
        return false;
    }

    static public function getTagsByBlogId(array $data, $blogId)
    {
        if ($blog = Blog::findBlog($data, $blogId))
        {
            $tags = [];
            foreach ($blog->tags as $tag)
            {
                $tags[] = $tag->toArray();
            }
            return $tags;
        }
        return false;
    }

    static public function getTagsByUserId(array $data, $userId)
    {
        if ($user = User::find($userId))
        {
            $tags = [];
            foreach ($user->tags as $tag)
            {
                $tags[] = $tag->toArray();
            }
            return $tags;
        }
        return false;
    }

    static public function deleteFromBlog(array $data, $tagId)
    {
        if (BlogTag::deleteByTagAndBlogId($data['blog_id'], $tagId))
        {
            // Delete tag when no blog links to it
            if (BlogTag::isOrphanTag($tagId))
            {
                return static::destroy($tagId);
            }
            return true;
        }
        return false;
    }

    /**
     * Build relationship with "user" table
     * 
     * @return Model
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
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
