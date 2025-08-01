<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('posts')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories,name',
        ]);

        $category = new Category();
        $category->name = $validated['name'];
        $category->slug = Str::slug($validated['name']);
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('admin.categories.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->name = $validated['name'];

        // Only update slug if name changed
        if ($category->name !== $validated['name']) {
            $category->slug = Str::slug($validated['name']);
        }

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        // Check if category has posts
        if ($category->posts()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category with associated posts. Please reassign posts first.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }
}
