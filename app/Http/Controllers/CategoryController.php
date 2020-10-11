<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Image;
use Illuminate\Support\Facades\File;
use Storage;
use Illuminate\Http\Response;

class CategoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data = Category::latest()->paginate(5);
        return view('categories.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $parent_categories = Category::where('parent_category', Null)->get()->toArray();
        return view('categories.create', compact('parent_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate([
            'category_name' => 'required|unique:categories',
            'category_image' => $request->hasFile('category_image') ? 'image|mimes:jpeg,png,jpg,gif,svg|max:2048' : "",
        ]);
        $file_name = NULL;
        if ($request->hasFile('category_image')) {
            $fieldFile = $request->file('category_image');
            $mime = $fieldFile->getClientOriginalExtension();
            $imageName = time() . "." . $mime;
            $image = Image::make($fieldFile)->resize(100, 59);
            Storage::disk('public')->put(config('constants.File_upload.category') . "/" . $imageName, (string) $image->encode());
            $file_name = $imageName;
        }
        $form_data = array(
            'category_name' => $request->category_name,
            'parent_category' => isset($request->parent_category) && !empty($request->parent_category) ? $request->parent_category : NULL,
            'category_image' => $file_name,
        );
        Category::create($form_data);
        \Session::flash('alert-success', 'Category  successfully created');
        return redirect('category')->with('success', 'Category Added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $parent_categories = Category::where('parent_category', Null)->get()->toArray();
        $data = Category::where('id', $id)->first();
        return view('categories.edit', compact('parent_categories', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $request->validate([
            'category_name' => 'required|unique:categories,category_name,' . $id . ',id',
            'category_image' => $request->hasFile('category_image') ? 'image|mimes:jpeg,png,jpg,gif,svg|max:2048' : "",
        ]);
        $fileName = "";
        $form_data = array(
            'category_name' => $request->category_name,
            'parent_category' => isset($request->parent_category) && !empty($request->parent_category) ? $request->parent_category : NULL,
        );
//        $cat = Category::find($id);
        if ($request->hasFile('category_image')) {
            $fieldFile = $request->file('category_image');
            $mime = $fieldFile->getClientOriginalExtension();
            $imageName = time() . "." . $mime;
            $image = Image::make($fieldFile)->resize(100, 59);
            Storage::disk('public')->put(config('constants.File_upload.category') . "/" . $imageName, (string) $image->encode());
            $form_data['category_image'] = $imageName;
        }
        \Session::flash('alert-success', 'Category  successfully updated');
        Category::whereId($id)->update($form_data);
        return redirect('category')->with('success', 'Category Added successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $data = Category::findOrFail($id);
        @unlink(storage_path('app/public/category/' . $data->category_image));
        $data->delete();
        return redirect('category')->with('success', 'Category is successfully deleted');
    }

    public function bulkdelete(Request $request) {
        $Id_array = $request->ids;
        if (!empty($Id_array)) {
            $cat_image = Category::whereIn('id', $Id_array)->get()->pluck('category_image')->toArray();
            $deleted = Category::whereIn('id', $Id_array)->delete();

            if (true) {
                foreach ($cat_image as $image) {
                    @unlink(storage_path('app/public/category/' . $image));
                }
                \Session::flash('alert-success', 'Category  successfully deleted');
                $data = Category::latest()->paginate(5);
                return true;
            }
        }
    }

}
