<?php

namespace App\Http\Controllers;

use App\Http\Resources\Category\Category as CategoryResource;
use App\Http\Resources\Category\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //     public function __construct()
    // {
    //     $this->middleware('permission:get-all-category', ['only' => ['index']]);
    //          $this->middleware('permission:get-a-category', ['only' => ['show']]);
    //          $this->middleware('permission:create-category', ['only' => ['store']]);
    //          $this->middleware('permission:update-category', ['only' => ['update']]);
    //          $this->middleware('permission:delete-category', ['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {
        //    return Categories::all();
        return new CategoryCollection(Category::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'category_name' => 'required'
            ]
        );
        $category = Category::create([
            'category_name' => $request->input('category_name'),
        ]);

        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate(
            $request,
            [
                'category_name' => 'required'
            ]
        );
        $category->update($request->only(['category_name']));
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['msg' => 'Category deleted'], 200);
    }
}
