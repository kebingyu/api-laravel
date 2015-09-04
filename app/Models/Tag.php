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

    static public function deleteByTag()
    {
    }
}
