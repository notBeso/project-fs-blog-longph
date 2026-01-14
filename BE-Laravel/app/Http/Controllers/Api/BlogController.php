<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\DTOs\BlogDTO;
use App\DTOs\CreateBlogDTO;
use App\Http\Requests\BlogRequest;

class BlogController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Blog::paginate(10));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        $dto = BlogDTO::fromRequest($request);
        $imagePath = $dto->handleImageUpload();
        $blog = Blog::create([
            'title' => $dto->title,
            'des' => $dto->des,
            'detail' => $dto->detail,
            'category' => $dto->category,
            'public' => $dto->public,
            'data_public' => $dto->data_public,
            'position' => $dto->position,
            'thumbs' => $imagePath,
        ]);
        return response()->json([
            'message' => 'Blog created successfully',
            'data' => $blog
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Blog::where('id', $id)->first();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, string $id)
    {
        $blog = Blog::where('id', $id)->first();
        $dto = BlogDTO::fromRequest($request);
        if($request->isRemoveThumbs) {
            $imagePath = $dto->handleImageUpload();
        }else{
            $imagePath = $blog->thumbs;
        }

        $updateData = [
            'title' => $dto->title,
            'des' => $dto->des,
            'detail' => $dto->detail,
            'category' => $dto->category,
            'public' => $dto->public,
            'data_public' => $dto->data_public,
            'position' => $dto->position,
            'thumbs' => $imagePath,
        ];
        $blog->update($updateData);

        return response()->json([
            'message' => 'Blog updated successfully',
            'data' => $blog->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::find($id);
        if(is_null($blog)){
            return redirect()->back()->withErrors(['message' => 'Blog not found.']);
        }
        $blog -> forceDelete();
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('q');

        return Blog::where('title', 'LIKE', "%{$searchTerm}%")->get();
    }

    public function locations() {
        return [
    		[ "id" => '1', "label" =>'Việt Nam' ],
        	[ "id" => '2', "label" => 'Châu Á' ],
        	[ "id" => '3', "label" => 'Châu Âu' ],
        	[ "id" => '4', "label" =>'Châu Mỹ' ],
	    ];
    }

    public function options() {
    	return [
            [ "value" => '1', "label" => 'Kinh Doanh' ],
            [ "value" => '2', "label" => 'Giải Trí' ],
            [ "value" => '3', "label" => 'Thế Giới' ],
            [ "value" => '4', "label" => 'Thời Sự' ],
	    ];
    }
}
