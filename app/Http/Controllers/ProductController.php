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
            'table' => [
                'delete' => ['link' => 'product.destroy'],
                'edit' => ['link' => 'product.edit'],
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
                        'label' =>'Category',
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
            'photo' => 'required|image|mimes:png,jpg',
            'price' => 'required'
        ]);
        $productPhoto = $request->file('photo')->getClientOriginalName();
        Products::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'photo' => $productPhoto,
            'price' => $request->price,
            'code' => $request->code
        ]);
        $request->photo->move(public_path('storage/images'), $productPhoto);
        return redirect()->route('product');
    }
    public function destroy(Products $product)
    {
        $product->delete();
        return redirect()->route('product');
    }
    public function edit(Products $product)
    {
        return view('admin.products.edit',[
            'title' => 'Product Edit',
            'breadcrumb' => [
                'Dashboard' => route('dashboard'),
                'Product List' => route('product')
            ],
            'action' => route('product.update',$product->id),
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
                        'value' => $product->name,
                        'label' =>'Product Name',
                        'placeholder' =>'Product Name'
                    ],
                    'code' => [
                        'type' => 'text',
                        'value' => $product->code,
                        'label' =>'Product Code',
                        'placeholder' =>'Product Code'
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'value' => $product->description,
                        'label' =>'Product Description',
                        'placeholder' =>'Product Description'
                    ],
                    'price' => [
                        'type' => 'number',
                        'value' => $product->price,
                        'label' =>'Price',
                        'placeholder' =>'Price'
                    ],
                    'category_id' => [
                        'type' => 'dropdown',
                        'label' =>'Category',
                        'value' => [
                            'selected' => $product->category_id,
                            'selection' => Category::all(),
                            'column' => 'name'
                        ],
                        'placeholder' =>'Select Category'
                    ],
                    'photo' => [
                        'type' => 'file',
                        'value' => $product->photo,
                        'label' =>'Photo',
                        'placeholder' =>'Photo'
                    ],
                ]
            ]
        ]);
    }
    public function update(Request $request,Products $product)
    {
        $updateChange = [];
        foreach($request->toArray() as $key => $value){
            if(!empty($value) && $key != '_token'){
                $updateChange[$key] = $value;
            }
        }
        foreach ($updateChange as $key => $value) {
            if($product->{$key} != $value){
                $product->{$key} = $value;
            }
        }
        $product->save();
        return redirect()->route('product.edit',$product->id);
    }
}
