<?php

namespace App\Http\Controllers;

use App\Models\Blog as BlogModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\Blog\CreateRequest;
use App\Http\Requests\Blog\ReadRequest;
use App\Http\Requests\Blog\UpdateRequest;
use App\Http\Requests\Blog\DeleteRequest;

class Blog extends Controller
{
    public function create(CreateRequest $request)
    {
        if ($blog = BlogModel::createBlog($request->input()))
        {
            $message = $this->getMessage('success', [
                'id'         => $blog->id,
                'created_at' => $blog->created_at,
            ]);
        }
        else
        {
            $message = $this->getMessage('error',
                [Request::ERROR_DATABASE_INTERNAL_ERROR]
            );
        }
        return json_encode($message);
    }

    public function read(ReadRequest $request, $blogId)
    {
        if ($blog = BlogModel::findBlog($request->input(), $blogId))
        {
            $message = $this->getMessage('success', $this->getFullData($blog));
        }
        else
        {
            $message = $this->getMessage('error',
                [Request::ERROR_DATABASE_BLOG_NOT_FOUND]
            );
        }
        return json_encode($message);
    }

    public function readAll(ReadRequest $request)
    {
        if ($blogs = BlogModel::findBlog($request->input()))
        {
            $data = [];
            foreach ($blogs as $blog)
            {
                $data[] = $this->getFullData($blog);
            }
            $message = $this->getMessage('success', $data);
        }
        else
        {
            $message = $this->getMessage('error',
                [Request::ERROR_DATABASE_BLOG_NOT_FOUND]
            );
        }
        return json_encode($message);
    }

    public function update(UpdateRequest $request, $blogId)
    {
        if ($blog = BlogModel::updateBlog($request->input(), $blogId))
        {
            $message = $this->getMessage('success', [
                'id'         => $blog->id,
                'updated_at' => $blog->created_at,
            ]);
        }
        else
        {
            $message = $this->getMessage('error',
                [Request::ERROR_DATABASE_BLOG_NOT_FOUND]
            );
        }
        return json_encode($message);
    }

    public function delete(DeleteRequest $request, $blogId)
    {
        if ($deleted = BlogModel::deleteBlog($request->input(), $blogId))
        {
            $message = $this->getMessage('success', [
                $deleted,
            ]);
        }
        else
        {
            $message = $this->getMessage('error',
                [Request::ERROR_DATABASE_BLOG_NOT_FOUND]
            );
        }
        return json_encode($message);
    }

    protected function getFullData($blog)
    {
        $data = $blog->toArray();
        foreach ($blog->tags as $tag)
        {
            $data['tags'][] = [
                'id'      => $tag->id,
                'content' => $tag->content,
            ];
        }
        return $data;
    }
}
