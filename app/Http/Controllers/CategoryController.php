<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','check.user']);
    }
    public function index()
    {
        $categories = Category::latest()->paginate(100);
        return view('admin.categories.index',[
            'title' => 'Category List',
            'breadcrumb' => [
                'Dashboard' => route('dashboard'),
            ],
            'action' => 'category',
            'table' => [
                'delete' => ['link' => 'category.destroy'],
                'edit' => ['link' => 'category.edit'],
                'name' => 'Category list',
                'data' => $categories,
                'order' => [
                    'name' => 'name',
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
                        'label' =>'Category Name',
                        'placeholder' =>'Category Name'
                    ],
                ]
            ]
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:categories,name',
        ]);
        Category::create([
            'name' => $request->name,
        ]);
        return redirect()->route('category');
    }
    public function destroy(Category $category)
    {
        if(Products::where('category_id',$category->id)){
            return redirect()->route('category',['fire' => 'error','msg' => 'Data masih di pakai di product']);
        }else{
            $category->delete();
            return redirect()->route('category');
        }
    }
    public function edit(Category $category)
    {
        return view('admin.categories.edit',[
            'title' => 'Category Edit',
            'breadcrumb' => [
                'Dashboard' => route('dashboard'),
                'Category List' => route('category')
            ],
            'action' => route('category.update',$category->id),
            'table' => [
                'delete' => ['link' => 'category.destroy'],
                'edit' => ['link' => 'category.edit'],
                'name' => 'Category list',
                'data' => $category,
                'order' => [
                    'name' => 'name',
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
                        'value' => $category->name,
                        'label' =>'Category Name',
                        'placeholder' =>'Category Name'
                    ],
                ]
            ]
        ]);
    }
    public function update(Request $request,Category $category)
    {
        $updateChange = [];
        foreach($request->toArray() as $key => $value){
            if(!empty($value) && $key != '_token'){
                $updateChange[$key] = $value;
            }
        }
        foreach ($updateChange as $key => $value) {
            if($category->{$key} != $value){
                $category->{$key} = $value;
            }
        }
        $category->save();
        return redirect()->route('category.edit',$category->id);
    }
}
