<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        $categories = Category::latest()->paginate(100);
        return view('admin.categories.index',[
            'title' => 'Product List',
            'breadcrumb' => [
                'Dashboard' => route('dashboard'),
            ],
            'action' => 'category',
            'delete' => 'category.destroy',
            'edit' => 'category.update',
            'table' => [
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
                        'label' =>'Product Name',
                        'placeholder' =>'Product Name'
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
    public function destroy(Request $request)
    {
       dd();
    }
}
