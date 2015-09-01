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

    static public function deleteUser($key)
    {
        if ($user = static::findUserByPrimaryKey($key))
        {
            return $user->delete();
        }
        return false;
    }
}
