<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Intervention\Image\Facades\Image;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data = Product::paginate(5);
        $categories = Category::get()->toArray();
        return view('products.index', compact('data', 'categories'));
    }

    public function searchProduct() {
        $searchStaring = isset($_GET['search_string']) && !empty($_GET['search_string']) ? $_GET['search_string'] : "";
        $category_id = isset($_GET['category_id']) && !empty($_GET['category_id']) ? $_GET['category_id'] : "";

        $data = Product::query();
        if (!empty($searchStaring) || !empty($category_id)) {
            $data->where(function($query) use($searchStaring, $category_id) {
                if (!empty($searchStaring)) {
                    $query->orWhere('product_name', "Like", "%" . $searchStaring . "%");
                }
                if (!empty($category_id)) {
                    $query->orWhere('category_id', $category_id);
                }
            });
        }
        $data = $data->paginate(5);
        $categories = Category::get()->toArray();
        return view('products.index', compact('data', 'categories','searchStaring','category_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $categories = Category::get()->toArray();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate([
            'product_name' => 'required|unique:products',
            'product_image' => $request->hasFile('product_image') ? 'image|mimes:jpeg,png,jpg,gif,svg|max:2048' : "",
        ]);
        $file_name = "";
        if ($request->hasFile('product_image')) {
            $fieldFile = $request->file('product_image');
            $mime = $fieldFile->getClientOriginalExtension();
            $imageName = time() . "." . $mime;
            $image = Image::make($fieldFile)->resize(100, 59);
            Storage::disk('public')->put(config('constants.File_upload.product') . "/" . $imageName, (string) $image->encode());
            $file_name = $imageName;
        }
        $form_data = array(
            'product_name' => $request->product_name,
            'category_id' => isset($request->category_id) && !empty($request->category_id) ? $request->category_id : NULL,
            'product_description' => $request->product_description,
            'product_image' => $file_name,
        );
        Product::create($form_data);
        \Session::flash('alert-success', 'Product data successfully added');
        return redirect('product');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = Product::findOrFail($id);
        return view('view', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $categories = Category::get()->toArray();
        $data = Product::findOrFail($id);

        return view('products.edit', compact('data', 'categories'));
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
            'product_name' => 'required|unique:products,product_name,' . $id . ',id',
            'product_image' => $request->hasFile('product_image') ? 'image|mimes:jpeg,png,jpg,gif,svg|max:2048' : "",
        ]);
        $form_data = array(
            'product_name' => $request->product_name,
            'category_id' => isset($request->category_id) && !empty($request->category_id) ? $request->category_id : NULL,
            'product_description' => $request->product_description,
        );
        $fileName = "";
        if ($request->hasFile('product_image')) {
            $fieldFile = $request->file('product_image');
            $mime = $fieldFile->getClientOriginalExtension();
            $imageName = time() . "." . $mime;
            $image = Image::make($fieldFile)->resize(100, 59);
            Storage::disk('public')->put(config('constants.File_upload.product') . "/" . $imageName, (string) $image->encode());
            $file_name = $imageName;
            $form_data['product_image'] = $imageName;
        }

        Product::whereId($id)->update($form_data);
        \Session::flash('alert-success', 'Product data successfully updated');
        return redirect('product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $data = Product::findOrFail($id);
        @unlink(storage_path('app/public/product/' . $data->product_image));
        $data->delete();
        return redirect('product')->with('success', 'Product is successfully deleted');
    }

    public function bulkdelete(Request $request) {
       $Id_array = $request->ids;
        if (!empty($Id_array)) {
            $cat_image = Product::whereIn('id', $Id_array)->get()->pluck('product_image')->toArray();
            $deleted = Product::whereIn('id', $Id_array)->delete();

            if (true) {
                foreach ($cat_image as $image) {
                    @unlink(storage_path('app/public/product/' . $image));
                }
                \Session::flash('alert-success', 'Product  successfully deleted');
                $data = Product::latest()->paginate(5);
                return true;
            }
        }
    }

}
