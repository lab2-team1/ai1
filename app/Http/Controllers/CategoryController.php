<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('dashboards.admin.categories.index', compact('categories'));
    }



    public function create()
    {
        $categories = Category::all();
        return view('dashboards.admin.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }


    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::where('id', '!=', $id)->get(); // Wyklucz aktualną kategorię, aby nie mogła być swoim rodzicem
        return view('dashboards.admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'parent_id' => 'nullable|exists:categories,id',
    ]);

    $category = Category::findOrFail($id);
    $category->update([
        'name' => $request->name,
        'parent_id' => $request->parent_id,
    ]);

    return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
}

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }
}
