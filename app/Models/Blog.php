<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Blog extends Model
{
    protected $connection = 'mysql';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'blog';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'content', 'user_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['token'];

    static public function createBlog(array $data)
    {
        return static::create($data);
    }

    static public function findBlog(array $data, $blogId = '')
    {
        if ($blogId)
        {
            $blog = static::findViewable($data, $blogId);
        }
        else
        {
            // Collections of model
            $blog = User::find($data['user_id'])->blogs;
        }
        return $blog;
    }

    static public function updateBlog(array $data, $blogId)
    {
        if ($blog = static::findViewable($data, $blogId))
        {
            $blog->update(array_filter($data));
            return $blog;
        }
        return false;
    }

    static public function deleteBlog(array $data, $blogId)
    {
        if ($blog = static::findDeletable($data, $blogId))
        {
            // Todo: need to delete relationship also
            return $blog->delete();
        }
        return false;
    }

    static protected function findViewable(array $data, $blogId)
    {
        $blog = static::find($blogId);
        if ($blog && $blog->user->id == $data['user_id'])
        {
            return $blog;
        }
        return false;
    }

    static protected function findEditable(array $data, $blogId)
    {
        return static::findViewable($data, $blogId);
    }

    static protected function findDeletable(array $data, $blogId)
    {
        return static::findViewable($data, $blogId);
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
     * Build relationship with "tag" table through pivot table "blog_tag"
     * 
     * @return Collections
     */
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'blog_tag', 'blog_id', 'tag_id');
    }
}
