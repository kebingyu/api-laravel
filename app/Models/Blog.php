<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
            $blog = static::where('id', $blogId)->where('user_id', $data['user_id'])->first();
        }
        else
        {
            // Collections of model
            $blog = static::where('user_id', $data['user_id'])->get();
        }
        return $blog;
    }

    static public function updateBlog(array $data, $blogId)
    {
        if ($blog = static::where('id', $blogId)->where('user_id', $data['user_id'])->first())
        {
            $blog->update(array_filter($data));
            return $blog;
        }
        return false;
    }

    static public function deleteBlog(array $data, $blogId)
    {
        if ($blog = static::where('id', $blogId)->where('user_id', $data['user_id'])->first())
        {
            return $blog->delete();
        }
        return false;
    }
}
