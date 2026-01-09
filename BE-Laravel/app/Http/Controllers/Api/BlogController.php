<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Redirect;

class BlogController
{
    public function checkThumbs(Request $request) {
        $thumbs = $request->thumbs;
        $newFileName = null;
        if(!is_null($thumbs)) {
            $newFileName = Str::uuid()->toString() . '.' . $thumbs->extension();
            Storage::disk('public')->put($newFileName, $thumbs->get());
	    }
        return $newFileName;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // official
        // return Blog::all();

        //pagination
        return response()->json(Blog::paginate(2));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $blog = new Blog;
        $newFileName = null;

        $blog->title = $request->title;
        $blog->des = $request->des;
        $blog->detail = $request->detail;
        $blog->category = $request->category;
        $blog->public = $request->public;
        $blog->data_public = $request->data_public;
        $blog->position = $request->position;
	    $blog->thumbs = $this->checkThumbs($request);;

        $blog->save();

        return $blog;
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
    public function update(Request $request, string $id)
    {
        $blog = Blog::where('id', $id)->first();

        $blog->title = $request->title;
        $blog->des = $request->des;
        $blog->detail = $request->detail;
        $blog->category = $request->category;
        $blog->public = $request->public;
        $blog->data_public = $request->data_public;
        $blog->position = $request->position;

        if($request->isRemoveThumbs) {
            $blog->thumbs = null;
        }

        $newFileName = $this->checkThumbs($request);

        if(!is_null($newFileName)) {
            $blog->thumbs = $newFileName;
        }

        $blog->save();

        return $blog;
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
        // return Redirect::route('posts.index')->with('success', 'Blog deleted successfully!');
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
