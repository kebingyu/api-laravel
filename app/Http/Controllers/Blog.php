<?php

namespace App\Http\Controllers;

use App\Models\Blog as BlogModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\Blog\CreateRequest;
use App\Http\Requests\Blog\ReadRequest;

class Blog extends Controller
{
    public function create(CreateRequest $request)
    {
        if ($blog = BlogModel::createBlog($request->input()))
        {
            $message = $this->getMessage('success', [
                'blog_id'    => $blog->id,
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
        if ($blog = BlogModel::find($blogId))
        {
            $message = $this->getMessage('success', $blog->toArray());
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
        if ($blogs = BlogModel::where('user_id', $request->input('user_id'))->get())
        {
            $data = [];
            foreach ($blogs as $blog)
            {
                $data[] = $blog->toArray();
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
}