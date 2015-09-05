<?php

namespace App\Http\Controllers;

use App\Models\Tag as TagModel;
use App\Models\Blog as BlogModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\Tag\CreateRequest;
use App\Http\Requests\Tag\ReadRequest;

class Tag extends Controller
{
    public function create(CreateRequest $request)
    {
        if ($tag = TagModel::createTag($request->input()))
        {
            $message = $this->getMessage('success', $tag->toArray());
        }
        else
        {
            $message = $this->getMessage('error',
                [Request::ERROR_DATABASE_INTERNAL_ERROR]
            );
        }
        return json_encode($message);
    }

    public function readByBlogId(ReadRequest $request, $blogId)
    {
        if ($blog = BlogModel::findBlog($request->input(), $blogId))
        {
            $data = [];
            foreach ($blog->tags as $tag)
            {
                $data[] = $tag->toArray();
            }
            $message = $this->getMessage('success', $data);
        }
        else
        {
            $message = $this->getMessage('error',
                [Request::ERROR_DATABASE_TAG_NOT_FOUND]
            );
        }
        return json_encode($message);
    }

    public function deleteByTagId($tagId)
    {
        if ($deleted = TagModel::deleteByTagId($tagId))
        {
            $message = $this->getMessage('success', [$deleted]);
        }
        else
        {
            $message = $this->getMessage('error',
                [Request::ERROR_DATABASE_INTERNAL_ERROR]
            );
        }
        return json_encode($message);
    }
}
