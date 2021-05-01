<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        $product = Products::with(['category'])->latest()->paginate(100);
        return view('admin.products.index',[
            'title' => 'Product List',
            'breadcrumb' => [
                'Dashboard' => route('dashboard'),
            ],
            'action' => 'product',
            'delete' => 'product',
            'edit' => 'product.update',
            'detail' => 'product.detail',
            'table' => [
                'name' => 'product list',
                'data' => $product,
                'order' => [
                    'name' => 'name',
                    'code' => 'code',
                    'description' => 'description',
                    'price' => 'Price',
                    'category.name' => 'Category',
                    'created_at' => 'Created At',
                    'updated_at' => 'Updated At',
                ],
            ],
            'forms' => [
                'name' => '',
                'type' => 'add',
                'data' => [
                    'name' => [
                        'type' => 'text',
                        'value' => null,
                        'label' =>'Product Name',
                        'placeholder' =>'Product Name'
                    ],
                    'code' => [
                        'type' => 'text',
                        'value' => null,
                        'label' =>'Product Code',
                        'placeholder' =>'Product Code'
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'value' => null,
                        'label' =>'Product Description',
                        'placeholder' =>'Product Description'
                    ],
                    'price' => [
                        'type' => 'number',
                        'value' => null,
                        'label' =>'Price',
                        'placeholder' =>'Price'
                    ],
                    'category_id' => [
                        'type' => 'dropdown',
                        'label' =>'Template',
                        'value' => [
                            'selected' => null,
                            'selection' => Category::all(),
                            'column' => 'name'
                        ],
                        'placeholder' =>'Select Category'
                    ],
                    'photo' => [
                        'type' => 'file',
                        'value' => null,
                        'label' =>'Photo',
                        'placeholder' =>'Photo'
                    ],
                ]
            ]
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:products,name',
            'code' => 'required|unique:products,code',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'photo' => 'required',
            'price' => 'required'
        ]);
        Products::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'photo' => $request->file('photo')->getClientOriginalName(),
            'price' => $request->price,
            'code' => $request->code
        ]);
        return redirect()->route('product');
    }
    public function destroy(Request $request)
    {
       dd();
    }
}
