<?php

namespace App\Http\Controllers;

use App\Models\Tag as TagModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\Tag\CreateRequest;
use App\Http\Requests\Tag\ReadRequest;
use App\Http\Requests\Tag\DeleteRequest;

class Tag extends Controller
{
    public function create(CreateRequest $request)
    {
        if ($tag = TagModel::createTag($request->input()))
        {
            // Tag with same content already used by this blog
            if ($tag === true)
            {
                $message = $this->getMessage('success', []);
            }
            else
            {
                $message = $this->getMessage('success', $tag->toArray());
            }
        }
        else
        {
            $message = $this->getMessage('error',
                [Request::ERROR_DATABASE_INTERNAL_ERROR]
            );
        }
        return json_encode($message, JSON_FORCE_OBJECT);
    }

    public function readByBlogId(ReadRequest $request, $blogId)
    {
        if ($tags = TagModel::getTagsByBlogId($request->input(), $blogId))
        {
            $message = $this->getMessage('success', $tags);
        }
        else
        {
            $message = $this->getMessage('error',
                [Request::ERROR_DATABASE_TAG_NOT_FOUND]
            );
        }
        return json_encode($message);
    }

    public function readByUserId(ReadRequest $request, $userId)
    {
        if ($tags = TagModel::getTagsByUserId($request->input(), $userId))
        {
            $message = $this->getMessage('success', $tags);
        }
        else
        {
            $message = $this->getMessage('error',
                [Request::ERROR_DATABASE_TAG_NOT_FOUND]
            );
        }
        return json_encode($message);
    }

    public function deleteFromBlog(DeleteRequest $request, $tagId)
    {
        if ($deleted = TagModel::deleteFromBlog($request->input(), $tagId))
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
