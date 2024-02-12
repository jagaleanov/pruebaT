<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::all();
            return view('categories.index', compact('categories'));
        } catch (\Exception $e) {
            Log::error("Error retrieving categories: {$e->getMessage()}");
            return redirect()->back()->with('error', 'Failed to retrieve categories');
        }
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(CategoryRequest $request)
    {
        try {
            Category::create($request->all());
            return redirect()->route('categories.index')->with('success', 'Category created successfully');
        } catch (\Exception $e) {
            Log::error('Category store error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to save category');
        }
    }

    public function show($id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return redirect()->back()->with('error', 'Category not found');
            }
            return view('categories.show', compact('category'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve category');
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }
        return view('categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return redirect()->back()->with('error', 'Category not found');
            }
            $category->update($request->all());
            return redirect()->route('categories.index')->with('success', 'Category updated successfully');
        } catch (\Exception $e) {
            Log::error("Error updating category: {$e->getMessage()}");
            return redirect()->back()->with('error', 'Failed to update category');
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return redirect()->back()->with('error', 'Category not found');
            }
            $category->delete();
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
        } catch (\Exception $e) {
            Log::error("Error deleting category: {$e->getMessage()}");
            return redirect()->back()->with('error', 'Failed to delete category');
        }
    }
}
