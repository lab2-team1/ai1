<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // 🟢 Lista kategorii
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // 🟢 Formularz tworzenia nowej kategorii
    public function create()
    {
        // Możemy potrzebować wszystkich kategorii do wyboru parent_id
        $parentCategories = Category::all();
        return view('categories.create', compact('parentCategories'));
    }

    // 🟢 Zapisanie nowej kategorii do bazy
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        Category::create($request->only(['name', 'parent_id']));

        return redirect()->route('categories.index')->with('success', 'Kategoria dodana.');
    }

    // 🟢 Formularz edycji kategorii
    public function edit(Category $category)
    {
        $parentCategories = Category::where('id', '!=', $category->id)->get(); // nie możesz być rodzicem samego siebie
        return view('categories.edit', compact('category', 'parentCategories'));
    }

    // 🟢 Zapisanie edytowanej kategorii
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $category->id
        ]);

        $category->update($request->only(['name', 'parent_id']));

        return redirect()->route('categories.index')->with('success', 'Kategoria zaktualizowana.');
    }

    // 🟢 Usunięcie kategorii
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategoria usunięta.');
    }
}
