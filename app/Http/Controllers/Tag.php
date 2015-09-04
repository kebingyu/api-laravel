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

    public function deleteByTag(DeleteRequest $request, $tagId)
    {
        if ($deleted = TagModel::deleteByTag($request->input(), $tagId))
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
